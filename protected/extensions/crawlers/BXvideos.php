<?php
Yii::import('ext.crawlers.BCrawler');
class BXvideos extends BCrawler{
	protected $identifier='xvideos';
	protected $videosGrabbed=0;
	protected $videosSkipped=0;

	public function getVideos($url='http://www.xvideos.com/new/'){
		$videos=$this->getVideosInformation($url);
		foreach($videos as $video){
			if ($this->add_video($video)) {
				$this->manageMessages('Video {videoUrl} embedded!',array('{videoUrl}'=>$video['url']));
				++$this->video_added;
			} else {
				$this->videosSkipped=$this->videosSkipped+1;
				$this->manageMessages('Failed to add video {videoUrl} to database!',array('{videoUrl}'=>$video['url']),'error');
			}
		}
	}

	public function getAvailableVideosForAutomaticGrab($url,$howManyVideos){
		$videos=$this->getVideosInformation($url);
		if(count($videos)<=$howManyVideos){
			$url=$url.'2';
			$videos2=$this->getVideosInformation($url);
			$videos=array_merge($videos,$videos2);
		}
		$max=count($videos);
		for($i=$howManyVideos;$i<$max;$i++){
			unset($videos[$i]);
		}
		return $videos;
	}


	public function getVideosInformation($url){
		$videos=array();
		$count	= 0;
		$this->manageMessages('Parsing remote html...');
		$html	= $this->clean_html(BCurl::string($url));
		if ($html) {
			preg_match_all('/<td width="183">(.*?)<\/td>/', $html, $matches);
			if (isset($matches['1'])) {
                $this->manageMessages('Processing videos...');
				foreach ($matches['1'] as $match) {
					++$this->videosGrabbed;
					if ($this->videosGrabbed > $this->overflow) {
						$this->errors[]	= 'Overflow reached (500)! Aborting!';
						return FALSE;
					}

					$video	= array(
					    'site'		=> 'xvideos',
						'url'		=> '',
						'title'		=> '',
						'desc'		=> '',
						'tags'  	=> '',
						'category'	=> '',
						'thumbs'	=> array(),
						'duration'	=> 0,
						'embed'		=> '',
						'size'		=> 0,
						'file_url'	=> ''
					);
					preg_match('/<a href="((.[^"]+)?)" class="miniature"><img/', $match, $matches_url);
					if (isset($matches_url['1'])) {
						$video['url']	= trim($matches_url['1']);
						$this->manageMessages('Processing {video}',array('{video}'=>$video['url']));
						if ($this->isVideoAlreadyAdded('xvideos', $video['url'])) {
							$this->manageMessages('Video already added!');
							++$this->video_already;
							$this->videosSkipped=$this->videosSkipped+1;
							continue;
						}
              		} else {
              			$this->manageMessages('Failed to find video title...continue!');
						$this->videosSkipped=$this->videosSkipped+1;
                  		continue;
              		}

					preg_match('/<span class="red" style="text-decoration:underline;">(.*?)<\/span>/', $match, $matches_title);
					if (isset($matches_title['1'])) {
						$video['title']	= strip_tags(htmlspecialchars($matches_title['1']));
					}

					preg_match('/<strong>\((.*?)\)<\/strong>/', $match, $matches_duration);
					if (!isset($matches_duration['1']) OR !$matches_duration['1']) {
						preg_match('/<b>\((.*?)\)<\/b>/', $match, $matches_duration);
					}

              		if (isset($matches_duration['1'])) {
                  		$video['duration'] = $this->durationToSeconds($matches_duration['1']);
              		}

					preg_match('/<img src="((.[^"]+)?)"onMouseOver/', $match, $matches_thumb);
					if (!isset($matches_thumb['1']) OR !$matches_thumb['1']) {
						preg_match('/<img src="((.[^"]+)?)" onMouseOver/', $match, $matches_thumb);
					}
					if (isset($matches_thumb['1'])) {
						$thumb_url       = $matches_thumb['1'];
                        $thumb_url       = str_replace('.jpg', '', $thumb_url);
                        $thumb_url  	 = substr($thumb_url, 0, strrpos($thumb_url, '.'));
						$video['thumbs'] = array(
							$thumb_url.'.1.jpg',
							$thumb_url.'.2.jpg',
							$thumb_url.'.3.jpg',
							$thumb_url.'.4.jpg',
							$thumb_url.'.5.jpg',
							$thumb_url.'.6.jpg',
							$thumb_url.'.7.jpg',
							$thumb_url.'.8.jpg',
							$thumb_url.'.9.jpg',
							$thumb_url.'.10.jpg',
							$thumb_url.'.11.jpg',
							$thumb_url.'.12.jpg',
							$thumb_url.'.13.jpg',
							$thumb_url.'.14.jpg',
							$thumb_url.'.15.jpg',
							$thumb_url.'.16.jpg',
							$thumb_url.'.17.jpg',
							$thumb_url.'.18.jpg',
							$thumb_url.'.19.jpg',
							$thumb_url.'.20.jpg',
							$thumb_url.'.21.jpg',
							$thumb_url.'.22.jpg',
							$thumb_url.'.23.jpg',
							$thumb_url.'.24.jpg',
							$thumb_url.'.25.jpg',
							$thumb_url.'.26.jpg',
							$thumb_url.'.27.jpg',
							$thumb_url.'.28.jpg',
							$thumb_url.'.29.jpg',
							$thumb_url.'.30.jpg');

					}

                    $video_id   = str_replace('http://www.xvideos.com/video', '', $video['url']);
                    $video_id   = explode('/', $video_id);
                    $video_id   = $video_id['0'];
					if ($video['title'] && $video['duration'] && $video['thumbs'] && isset($video_id)) {
						$tags           = array();
                        $tags_arr       = explode(' ', strtolower($this->stringHelper->prepare_string($video['title'])));
                        foreach ($tags_arr as $tag) {
                      		if (strlen($tag) >= 5) {
                          		$tags[] = $tag;
                            }
                        }

                        $video['tags']  = implode(' ', $tags);
						$video['embed']	= '<object wmode="transparent" width="{embedWidth}" height="{embedHeight}" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" ><param name="quality" value="high" /><param name="bgcolor" value="#000000" /><param name="allowScriptAccess" value="always" /><param name="movie" value="http://static.xvideos.com/swf/flv_player_site_v4.swf" /><param name="allowFullScreen" value="true" /><param name="flashvars" value="id_video='.$video_id.'" /><embed src="http://static.xvideos.com/swf/flv_player_site_v4.swf" allowscriptaccess="always" width="{embedWidth}" height="{embedHeight}" menu="false" quality="high" bgcolor="#000000" allowfullscreen="true" flashvars="id_video='.$video_id.'" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="transparent" /></object>';
						$videos[]=$video;
					} else {
						$this->videosSkipped=$this->videosSkipped+1;
						$this->manageMessages('Failed to get video details for {videoUrl} !',array('{videoUrl}'=>$video['url']),'error');
					}

				}
			} else {
				$this->manageMessages('No videos found while parsing {url}!',array('{url}'=>$url),'error');
			}
		} else {
			$this->manageMessages('Failed to download {url}!',array('{url}'=>$url),'error');
		}

		if ($this->errors) {
			return FALSE;
		}

		return $videos;
	}


}
