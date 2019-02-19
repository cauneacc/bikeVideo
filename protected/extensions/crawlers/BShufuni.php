<?php

Yii::import('ext.crawlers.BCrawler');

class BShufuni extends BCrawler {

    protected $identifier = 'shufuni';
    protected $videosGrabbed = 0;
    protected $videosSkipped = 0;

    public function getVideos($url='http://www.shufuni.com/default.aspx?page=1') {
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
            if (is_array($videos2) == true) {
                $videos = array_merge($videos, $videos2);
            }
        }
        $max = count($videos);
        for ($i = $howManyVideos; $i < $max; $i++) {
            unset($videos[$i]);
        }
        return $videos;
    }

    public function getVideosInformation($url) {
        $videos = array();
        $count = 0;
        $this->manageMessages('Parsing remote html...');
        $html = $this->clean_html(BCurl::string($url, 'k_visit=3; shfn=cTC6psOvCC5qGNFWzSU7xg=='));
        if ($html) {
            preg_match_all('/<div class="HomepageblockOneImage">(.*?)style="clear: both; height: 15px;">/', $html, $matches);
            if (isset($matches['1']) && $matches['1']) {
                $this->manageMessages('Processing videos...');
                foreach ($matches['1'] as $match) {
                    ++$this->videosGrabbed;
                    if ($this->videosGrabbed > $this->overflow) {
                        $this->errors[] = 'Overflow reached (500)! Aborting!';
                        return FALSE;
                    }

                    $video = array(
                        'site' => 'shufuni',
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
                    preg_match('/<a href=\'(.*?)\' > <img src="/', $match, $matches_url);
                    if (isset($matches_url['1'])) {
                        $video['url'] = 'http://www.shufuni.com' . trim($matches_url['1']);
                        $this->manageMessages('Processing {video}', array('{video}' => $video['url']));
                        if ($this->isVideoAlreadyAdded('shufuni', $video['url'])) {
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


                    preg_match('/<div class="TimeVideo">(.*?)<\/div>/', $match, $matches_duration);
                    if (isset($matches_duration['1']) && $matches_duration['1']) {
                        $video['duration'] = $this->durationToSeconds($matches_duration['1']);
                    }

                    preg_match('/\'> (.*?) <\/a> <\/div> <div style="clear: both;/', $match, $matches_title);
                    if (isset($matches_title['1']) and $matches_title['1']) {
                        $video['title'] = strip_tags(stripslashes($matches_title['1']));
                    }


                    preg_match('/<img src="(.*?)" id="(.*?)" class="ImgBorder_4NEW"/', $match, $matches_thumb);

                    if (isset($matches_thumb['1']) && $matches_thumb['1']) {
                        $video['thumbs'] = array(
                            $matches_thumb['1']
                        );
                    }
                    
                    
                    
                    
                    if ($video['title'] && $video['duration'] && $video['thumbs']) {
                        $content = $this->clean_html(BCurl::string($video['url'], 'IAgree=yes; StartClick=1; k_visit=3; shfn=cTC6psOvCC5qGNFWzSU7xg=='));
                        preg_match('/<div id="videoTagDIV">(.*?)<\/div>/', $content, $matches_tags);
                        if (isset($matches_tags['1']) && $matches_tags['1']) {
                            $matches_tags = $matches_tags['1'];
                            preg_match_all("/<a class='videoPageLinks' href='(.*?)'>(.*?)<\/a>/", $matches_tags, $matches_tag);
                            $tags = array();
                            if (isset($matches_tag['2'])) {
                                foreach ($matches_tag['2'] as $tag) {
                                    $tags[] = strtolower($this->stringHelper->prepare_string($tag));
                                }

                                $video['tags'] = implode(' ', $tags);
                            }
                        }
                        preg_match('/so.addVariable\("CDNUrl", "(.*?)"\);/', $content, $matches_code);
                        if (isset($matches_code['1']) && $matches_code['1']) {
                            $cdnUrl = $matches_code['1'];
                            $video['videoFlvUrl']=$cdnUrl;
                            $video['videoEmbedHotlink']=$this->createFlashEmbedCode($cdnUrl);
                        }
                        preg_match('/so.addVariable\("WID", "(.*?)"\);/', $content, $matches_id);
                        if (isset($matches_id['1']) && $matches_id['1']) {
                            $video_id = $matches_id['1'];
                        }

//						preg_match('/EMBED:(.*?)" \/>/', $content, $matchEmbed);
//						if(isset($matchEmbed['1']) && $matchEmbed['1']){
//							preg_match('/value="(.*?)&lt;div>/', $matchEmbed['1'], $embedCode);
//							if(isset($embedCode['1']) && $embedCode['1']){
//								$embedCode=html_entity_decode($embedCode['1']);
//								$embedCode=preg_replace('/width="[0-9]+"/', 'width="{embedWidth}"', $embedCode);
//								$embedCode=preg_replace('/height="[0-9]+"/', 'height="{embedHeight}"', $embedCode);
//							}
//						}

                        $video_url = explode('+', str_replace('http://www.shufuni.com/', '', $video['url']));
                        $video['category'] = $video_url['0'];
                        if ($video['tags'] && isset($cdnUrl) && $cdnUrl &&
                                isset($video_id) && $video_id && $video['category']) {

                            $video['embed'] = '<object width="{embedWidth}" height="{embedHeight}"><param name="movie" value="http://www.shufuni.com/Flash/" flashvars="VideoCode=' . $video_code . '&WID=' . $video_id . '"></param><param name="allowFullScreen" value="true"><param name="allowScriptAccess" value="always" wmode="transparent"/><embed src="http://www.shufuni.com/Flash/flvplayer_0200.swf" type="application/x-shockwave-flash" width="{embedWidth}" height="{embedHeight}" allowFullScreen="true" allowScriptAccess="always" flashvars="CDNUrl=' . $cdnUrl . '&WID=' . $video_id . '" wmode="transparent"></embed></object>';
                            $videos[] = $video;
                        } else {
                            $this->videosSkipped = $this->videosSkipped + 1;
                            $this->manageMessages('Failed to get video details for {videoUrl} !', array('{videoUrl}' => $video['url']), 'error');
                        }
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

}
