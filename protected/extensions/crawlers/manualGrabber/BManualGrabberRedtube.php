<?php
Yii::import('ext.crawlers.BRedtube');
class BManualGrabberRedtube{
	public function getVideos($conditions,$numberOfVideos){
		$crawler=new BRedtube();
		$url=$this->getListVideosUrls($conditions);
		return $crawler->getAvailableVideosForAutomaticGrab($url, $numberOfVideos);
	}

	public function addEmbededVideos($videos){
		$crawler=new BRedtube();
		$crawler->addEmbededVideos($videos);
	}

	public function addHotlinkedVideos($videos){
		
	}

	protected function getListVideosUrls($conditions){
		$url='';
		if(isset($conditions['categories'])==true){
			$url=$url.'/redtube/'.$conditions['categories'];
		}
		if(isset($conditions['order'])==true){
			if($url!=''){
				$url='?sorting='.str_replace('?', '&', $conditions['order']);
			}else{
				$url=$conditions['order'];
			}
		}
		return 'http://www.redtube.com'.$url;

	}

	public function getPossibleConditions(){
		return array('categories'=>array(''=>'All',
'amateur'=>'Amateur',
'anal'=>'Anal',
'asian'=>'Asian',
'bigtits'=>'Big Tis',
'blowjob'=>'Blowjob',
'cumshot'=>'Cumshot',
'ebony'=>'Ebony',
'facials'=>'Facials',
'fetish'=>'Fetish',
'gangbang'=>'Gangbang',
'gay'=>'Gay',
'group'=>'Group',
'hentai'=>'Hentai',
'interracial'=>'Interracial',
'japanese'=>'Japanese',
'latina'=>'Latina',
'lesbian'=>'Lesbian',
'masturbation'=>'Masturbation',
'mature'=>'Mature',
'milf'=>'Milf',
'public'=>'Public',
'squirting'=>'Squirting',
'teens'=>'Teens',
'wildcrazy'=>'Wild and crazy'),
			'order'=>array('newest'=>'Newest',
				'top'=>'Top Rated Weekly',
				'top?period=monthly'=>'Top Rated Monthly',
				'top?period=alltime'=>'Top Rated All Time',
				'mostviewed'=>'Most Viewed Weekly',
				'mostviewed?period=monthly'=>'Most Viewed Monthly',
				'mostviewed?period=alltime'=>'Most Viewed All Time'

				)
	);
	}
}
?>
