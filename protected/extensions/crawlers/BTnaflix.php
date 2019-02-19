<?php
Yii::import('ext.crawlers.BCrawler');
class BTnaflix extends BCrawler{
	protected $identifier='tnaflix';
	protected $videosGrabbed=0;
	protected $videosSkipped=0;

	public function getVideos($url='http://www.tnaflix.com/new/'){
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


	protected function getVideosInformation($url){
		$videos=array();
		$count	= 0;
		$this->manageMessages('Parsing remote html...');
		$html=$this->clean_html(BCurl::string($url, 'video_type_preview=image'));
		if($html){
			preg_match_all('/<div class="video">(.*?)<span class="date">/', $html, $matches);
			if(!isset($matches['1']) OR !$matches['1']){
				preg_match_all('/<div class="video svideo">(.*?)span><\/div>/', $html, $matches);
				if(!isset($matches['1']) OR !$matches['1']){
					preg_match_all('/<div class="video" id="video(.*?)">(.*?)<\/span>/', $html, $matches);
					$matches['1']=$matches['2'];
				}
			}

			if(isset($matches['1'])){
				$this->manageMessages('Processing videos...');
				foreach($matches['1'] as $match){
					++$this->videosGrabbed;
					if($this->videosGrabbed > $this->overflow){
						$this->errors[]='Overflow reached (500)! Aborting!';
						return FALSE;
					}

					$video=array(
						'site'=>'tnaflix',
						'url'=>'',
						'title'=>'',
						'desc'=>'',
						'tags'=>'',
						'category'=>'',
						'thumbs'=>array(),
						'duration'=>0,
						'embed'=>'',
						'size'=>0,
						'file_url'=>''
					);
					preg_match('/<a href="(.*?)" class="videoThumb"/', $match, $matches_url);
					if(isset($matches_url['1'])){
						$video['url']=trim($matches_url['1']);

						if(substr($video['url'], 0,7)!='http://'){
							$video['url']='http://www.tnaflix.com'.$video['url'];
						}
						$this->manageMessages('Processing {video}', array('{video}'=>$video['url']));
						if($this->isVideoAlreadyAdded('tnaflix', $video['url'])){
							$this->manageMessages('Video already added!');
							++$this->video_already;
							$this->videosSkipped=$this->videosSkipped+1;
							continue;
						}
					}else{
						$this->manageMessages('Failed to find video title...continue!');
						$this->videosSkipped=$this->videosSkipped+1;
						continue;
					}

					preg_match('/border="0" alt="(.*?)" \/>/', $match, $matches_title);
					if(isset($matches_title['1'])){
						$video['title']=strip_tags(htmlspecialchars($matches_title['1']));
					}

					preg_match('/<span class="widescreen">(.*?)$/', $match, $matches_duration);
					if(!isset($matches_duration['1']) OR !$matches_duration['1']){
						preg_match('/<span class="standard_screen">(.*?)$/', $match, $matches_duration);
					}
					if(isset($matches_duration[1])){
						$video['duration']=$this->durationToSeconds($matches_duration[1]);
					}

					preg_match('/src="(.*?)"/', $match, $matches_thumb);
					if(isset($matches_thumb['1']) AND $matches_thumb['1']){
						$thumb_url=explode('_', $matches_thumb['1']);
						$url_left=substr($thumb_url['0'], 0, strrpos($thumb_url['0'], '/'));
						$video['thumbs']=array(
							$url_left.'/1_'.$thumb_url['1'],
							$url_left.'/2_'.$thumb_url['1'],
							$url_left.'/3_'.$thumb_url['1'],
							$url_left.'/4_'.$thumb_url['1'],
							$url_left.'/5_'.$thumb_url['1'],
							$url_left.'/6_'.$thumb_url['1'],
							$url_left.'/7_'.$thumb_url['1'],
							$url_left.'/8_'.$thumb_url['1'],
							$url_left.'/9_'.$thumb_url['1'],
							$url_left.'/10_'.$thumb_url['1'],
							$url_left.'/11_'.$thumb_url['1'],
							$url_left.'/12_'.$thumb_url['1'],
							$url_left.'/13_'.$thumb_url['1'],
							$url_left.'/14_'.$thumb_url['1'],
							$url_left.'/15_'.$thumb_url['1'],
							$url_left.'/16_'.$thumb_url['1'],
							$url_left.'/17_'.$thumb_url['1'],
							$url_left.'/18_'.$thumb_url['1'],
							$url_left.'/19_'.$thumb_url['1'],
							$url_left.'/20_'.$thumb_url['1'],
							$url_left.'/21_'.$thumb_url['1'],
							$url_left.'/22_'.$thumb_url['1'],
							$url_left.'/23_'.$thumb_url['1'],
							$url_left.'/24_'.$thumb_url['1'],
							$url_left.'/25_'.$thumb_url['1'],
							$url_left.'/26_'.$thumb_url['1'],
							$url_left.'/27_'.$thumb_url['1'],
							$url_left.'/28_'.$thumb_url['1'],
							$url_left.'/29_'.$thumb_url['1'],
							$url_left.'/30_'.$thumb_url['1']
						);
					}
					$video_id=explode('=', $video['url']);
					$video_id=$video_id['1'];
					if($video['title'] && $video['duration'] && $video['thumbs'] && isset($video_id)){
						$content=$this->clean_html(BCurl::string($video['url'], 'video_type_preview=image'));
						preg_match('/Categories:<\/span> <span class="listView"> <a href="(.*?)">(.*?)<\/a>/', $content, $matches_category);
						if(isset($matches_category['2'])){
							$video['category']=strip_tags(stripslashes($matches_category['2']));
						}
						preg_match('/<span class="infoTitle">Tags:<\/span> <span class="listView">(.*?)<\/span> <\/li>/', $content, $matches_tags);
						if(isset($matches_tags['1'])){
							preg_match_all('/<a href="(.*?)">(.*?)<\/a>/', $matches_tags['1'], $matches_urls);
							if(isset($matches_urls['2'])){
								$tags=array();
								foreach($matches_urls['2'] as $tag){
									$tags[]=$this->stringHelper->prepare_string(strip_tags(stripslashes($tag)));
								}

								$video['tags']=strtolower(implode(' ', $tags));
							}
						}

						$video['embed']='<object type="application/x-shockwave-flash" data="http://www.tnaflix.com/embedding_player/player_v0.2.1.swf" wmode="transparent" width="{embedWidth}" height="{embedHeight}"><param name="allowFullScreen" value="true" /><param name="allowScriptAccess" value="always" /><param name="movie" value="http://www.tnaflix.com//embedding_player/player_v0.2.1.swf" /><param name="FlashVars" value="config=embedding_feed.php?viewkey='.$video_id.'"/></object>';
						if($video['category'] && $video['tags'] && $video['embed']){
							$videos[]=$video;
						}else{
							$this->videosSkipped=$this->videosSkipped+1;
							$this->manageMessages('Failed to get video details for {videoUrl} !', array('{videoUrl}'=>$video['url']), 'error');
						}
					}else{
						$this->videosSkipped=$this->videosSkipped+1;
						$this->manageMessages('Failed to get video details for {videoUrl} !', array('{videoUrl}'=>$video['url']), 'error');
					}
				}
			}else{
				$this->manageMessages('No videos found while parsing {url}!', array('{url}'=>$url), 'error');
			}
		}else{
			$this->manageMessages('Failed to download {url}!', array('{url}'=>$url), 'error');
		}

		if($this->errors){
			return FALSE;
		}

		return $videos;
	}

}
