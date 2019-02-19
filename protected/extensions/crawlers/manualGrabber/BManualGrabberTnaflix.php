<?php
Yii::import('ext.crawlers.BTnaflix');
class BManualGrabberTnaflix{
	public function getVideos($conditions,$numberOfVideos){
		$crawler=new BTnaflix();
		$url=$this->getListVideosUrls($conditions);
		return $crawler->getAvailableVideosForAutomaticGrab($url, $numberOfVideos);
	}

	public function addEmbededVideos($videos){
		$crawler=new BTnaflix();
		$crawler->addEmbededVideos($videos);
	}

	public function addHotlinkedVideos($videos){
		
	}

	protected function getListVideosUrls($conditions){
		$url='';
		if(isset($conditions['categories'])==true){
			$url=$url.$conditions['categories'];
		}
		if(isset($conditions['order'])==true){
			if($url!=''){
				if($conditions['order']=='beingWatched'){
					$url=$url.'/being-watched/';
				}elseif($conditions['order']=='mostRecent'){
					$url=$url.'/most-recent/';
				}elseif($conditions['order']=='mostViewed'){
					$url=$url.'/most-viewed/';
				}elseif($conditions['order']=='topRated'){
					$url=$url.'/top-rated/';
				}
			}else{
				if($conditions['order']=='beingWatched'){
					$url=$url.'watched/1';
				}elseif($conditions['order']=='mostRecent'){
					$url=$url.'new/1';
				}elseif($conditions['order']=='mostViewed'){
					$url=$url.'popular/1';
				}elseif($conditions['order']=='topRated'){
					$url=$url.'toprated/1';
				}
			}
		}
		return 'http://www.tnaflix.com'.$url;
	}

	public function getPossibleConditions(){
		return array('categories'=>array(''=>'All',
'video.php'=>'All',
'amateur-porn'=>'Amateur',
'anal-porn'=>'Anal &amp; Ass',

'asian-porn'=>'Asians',
'babe-videos'=>'Babes',
'bbw-porn'=>'BBW',
'bizarre-porn'=>'Bizarre',
'blonde-porn'=>'Blonde',
'blowjob-videos'=>'Blowjobs &amp; Oral Sex',

'brunette-porn'=>'Brunette',
'cartoon-porn'=>'Cartoon',
'classic-porn'=>'Classic',
'creampie-videos'=>'Creampie',
'cum-videos'=>'Cumshots',
'double-penetration'=>'Double Penetration',

'ebony-porn'=>'Ebony',
'euro-porn'=>'Euro Porn',
'facial-porn'=>'Facial Cum Shots',
'fat-porn'=>'Fat Girls',
'fetish-videos'=>'Fetish Sex',
'fisting-videos'=>'Fisting',

'feet-porn'=>'Foot Fetish',
'gang-bang'=>'Gang Bang',
'gay-porn'=>'Gay / Bi-Male',
'granny-porn'=>'Granny',
'group-sex'=>'Group Sex',
'hairy-porn'=>'Hairy',

'hardcore-porn'=>'Hardcore Porn',
'hentai-porn'=>'Hentai',
'homemade-porn'=>'Home made',
'big-cock'=>'Huge Cocks',
'big-boobs'=>'Huge Tits',
'indian-porn'=>'Indian',

'interracial-porn'=>'Interracial',
'latina-porn'=>'Latinas',
'lesbian-porn'=>'Lesbian',
'masturbation-videos'=>'Masturbation',
'mature-porn'=>'Mature',
'milf-porn'=>'MILF ',

'petite-porn'=>'Petite',
'piss-videos'=>'Piss',
					'pov-porn'=>'POV',
'pregnant-porn'=>'Pregnant ',
'public-porn'=>'Public',
'reality-porn'=>'Reality Porn',

'redhead-porn'=>'Redhead',
'toy-videos'=>'Sex Toys',
'shemale-porn'=>'Shemale/Trans',
'softcore-videos'=>'Softcore',
'spanking-videos'=>'Spanking',
'squirting-videos'=>'Squirting',

'storyline-porn'=>'Storyline',
'teen-porn'=>'Teens 18+',
'xmas-competition'=>'Xmas Competition'),
			'order'=>array('watched/1'=>'All Being Watched',
				'new/1/'=>'All Most Recent',
				'popular/1/'=>'All Popular',
				'toprated/1/'=>'All Top Rated',
				'mostviewed'=>'Most Viewed Weekly',
				'mostviewed?period=monthly'=>'Most Viewed Monthly',
				'mostviewed?period=alltime'=>'Most Viewed All Time'

				)
	);
	}
}
?>
