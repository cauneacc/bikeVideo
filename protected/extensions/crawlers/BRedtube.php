<?php

Yii::import('ext.crawlers.BCrawler');

class BRedtube extends BCrawler {

    protected $identifier = 'redtube';
    protected $videosGrabbed = 0;
    protected $videosSkipped = 0;

    public function getVideos($url='http://www.redtube.com/?page=1') {
        $videos = $this->getVideosInformation($url);
        foreach ($videos as $video) {
            if ($this->add_video($video)) {
                $this->manageMessages('Video {videoUrl} embedded!', array('{videoUrl}' => $video['url']));
                ++$this->video_added;
            } else {
                $this->videosSkipped = $this->videosSkipped + 1;
                $this->manageMessages('Failed to add video {videoUrl} to database!', array('{videoUrl}' => $video['url']), 'error');
            }
        }
    }

    public function getAvailableVideosForAutomaticGrab($url, $howManyVideos) {
        $videos = $this->getVideosInformation($url);
        if (count($videos) <= $howManyVideos) {
            if (strpos($url, '?') === false) {
                $url = $url . '?page=2';
            } else {
                $url = $url . '&page=2';
            }
            $videos2 = $this->getVideosInformation($url);
            $videos = array_merge($videos, $videos2);
        }
        $max = count($videos);
        for ($i = $howManyVideos; $i < $max; $i++) {
            unset($videos[$i]);
        }
        return $videos;
    }

    protected function getVideosInformation($url) {
        $videos = array();
        $count = 0;
        $this->manageMessages('Parsing remote html...');


        $html = $this->clean_html(BCurl::string($url, 'iVisited=1; cookAV=1'));
        if ($html) {
            preg_match_all('/<li> <div class="video">(.*?)<\/span>/ms', $html, $matches);
            if (isset($matches['1']) && $matches['1']) {
                $this->manageMessages('Processing videos...');
                foreach ($matches['1'] as $match) {
                    ++$this->videosGrabbed;
                    if ($this->videosGrabbed > $this->overflow) {
                        $this->errors[] = 'Overflow reached (500)! Aborting!';
                        return FALSE;
                    }

                    $video = array(
                        'site' => 'redtube',
                        'url' => '',
                        'title' => '',
                        'desc' => '',
                        'tags' => '',
                        'category' => '',
                        'thumbs' => array(),
                        'duration' => 0,
                        'embed' => '',
                        'size' => 0,
                        'file_url' => ''
                    );
                    preg_match('/<a href="(.*?)" title="(.*?)"> <img/', $match, $matches_url);
                    if (isset($matches_url['1']) && isset($matches_url['2'])) {
                        $video['url'] = $matches_url['1'];
                        $video['title'] = strip_tags(stripslashes($matches_url['2']));
                        $this->manageMessages('Processing {video}', array('{video}' => $video['url']));
                        if ($this->isVideoAlreadyAdded('redtube', $video['url'])) {
                            $this->manageMessages('Video already added!');
                            ++$this->video_already;
                            $this->videosSkipped = $this->videosSkipped + 1;
                            continue;
                        }
                    } else {
                        $this->manageMessages('Failed to find video title...continue!');
                        $this->videosSkipped = $this->videosSkipped + 1;
                        continue;
                    }
                    preg_match('/<span class="d">(.*?)$/', $match, $matches_duration);
                    if (isset($matches_duration['1'])) {
                        $video['duration'] = $this->durationToSeconds($matches_duration['1']);
                    }


                    preg_match('/class="t" src="(.*?)" onmouseout/', $match, $matches_thumb);
                    if (isset($matches_thumb['1'])) {
                        $thumb_url = $matches_thumb['1'];
                        $thumb_url = substr($thumb_url, 0, strrpos($thumb_url, '_'));
                        $video_id = intval(substr($thumb_url, strrpos($thumb_url, '/') + 1));
                        $video['thumbs'] = array(
                            $thumb_url . '_002.jpg',
                            $thumb_url . '_003.jpg',
                            $thumb_url . '_004.jpg',
                            $thumb_url . '_005.jpg',
                            $thumb_url . '_006.jpg',
                            $thumb_url . '_007.jpg',
                            $thumb_url . '_008.jpg',
                            $thumb_url . '_009.jpg',
                            $thumb_url . '_010.jpg',
                            $thumb_url . '_011.jpg',
                            $thumb_url . '_012.jpg',
                            $thumb_url . '_013.jpg',
                            $thumb_url . '_014.jpg',
                            $thumb_url . '_015.jpg'
                        );
                    }

                    if ($video['title'] && $video['duration'] && $video['thumbs'] && isset($video_id)) {
                        $tags = array();
                        $tags_arr = explode(' ', strtolower($this->stringHelper->prepare_string($video['title'])));
                        foreach ($tags_arr as $tag) {
                            if (strlen($tag) >= 5) {
                                $tags[] = $tag;
                            }
                        }

                        $video['tags'] = implode(' ', $tags);
                        $video['embed'] = '<object wmode="transparent" height="{embedHeight}" width="{embedWidth}"><param name="movie" value="http://embed.redtube.com/player/"><param name="FlashVars" value="id=' . $video_id . '&style=redtube"><embed src="http://embed.redtube.com/player/?id=' . $video_id . '&style=redtube" wmode="transparent" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" height="{embedHeight}" width="{embedWidth}" /></object>';
                        $videos[] = $video;
                    } else {
                        $this->videosSkipped = $this->videosSkipped + 1;
                        $this->manageMessages('Failed to get video details for {videoUrl} !', array('{videoUrl}' => $video['url']), 'error');
                    }
                }
            } else {
                $this->manageMessages('No videos found while parsing {url}!', array('{url}' => $url), 'error');
            }
        } else {
            $this->manageMessages('Failed to download {url}!', array('{url}' => $url), 'error');
        }

        if ($this->errors) {
            return FALSE;
        }

        return $videos;
    }

    public function getFlvUrl($videoIds) {
        $urls = array();
        foreach ($videoIds as $key => $id) {
            $urls[$key] = 'http://www.redtube.com/' . $id;
        }
        $pages = BCurl::stringConcomitent($urls);
        $flvUrls = array();
        foreach ($pages as $key => $page) {
            if (empty($page) == false) {
                preg_match_all('/&hashlink=(.*?)&embed=/ms', $page, $matches);
                if (isset($matches[1])) {
                    if (isset($matches[1][0])) {
                        $flvUrls[$key] = urldecode($matches[1][0]);
                    }
                }
            }
        }
        return $flvUrls;
    }


}
