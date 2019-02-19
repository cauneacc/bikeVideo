<?php

Yii::import('ext.crawlers.BShufuni');

class BManualGrabberShufuni {

    public $isHotlinkPossible = true;
    public $isDownloadPossible = true;

    public function getVideos($conditions, $numberOfVideos) {
        $crawler = new BShufuni();
        $url = $this->getListVideosUrls($conditions);
        return $crawler->getAvailableVideosForAutomaticGrab($url, $numberOfVideos);
    }

    public function addEmbededVideos($videos) {
        $crawler = new BShufuni();
        $crawler->addMultipleVideos($videos);
    }

    public function addHotlinkedVideos($videos) {
       $crawler = new BShufuni();
       $crawler->addMultipleVideos($videos);        
    }
    
    public function addLocalHostedVideos($videos) {
        $crawler = new BShufuni();
        foreach ($videos as $key => $video) {
            $videos[$key]['downloadVideoFile']=true;
        }
        $crawler->addMultipleVideos($videos);
    }    

    protected function getListVideosUrls($conditions) {
        $url = '';
        if (isset($conditions['categories']) == true) {
            $url = $url . $conditions['categories'];
        }
        if (isset($conditions['order']) == true) {
            if ($url == '') {
                if ($conditions['order'] == 'or=12&sor=12') {
                    $url = 'default.aspx?lt=12';
                } elseif ($conditions['order'] === 'or=2&sor=3' or $conditions['order'] === 'or=2&sor=4'
                        or $conditions['order'] === 'or=2&sor=5' or $conditions['order'] === 'or=2&sor=6') {
                    $url = 'default.aspx?lt=6';
                }
            } else {
                $url = $url . '&' . $conditions['order'];
            }
        }
        return 'http://www.shufuni.com' . $url;
    }

    public function getPossibleConditions() {
        return array('categories' => array('' => 'All',
                '/videos/?ct=amateur' => 'Amateur',
                '/videos/?ct=anal' => 'Anal',
                '/videos/?ct=asians' => 'Asians',
                '/videos/?ct=bbw' => 'BBW',
                '/videos/?ct=bigtits' => 'Big Tits',
                '/videos/?ct=blonde' => 'Blonde',
                '/videos/?ct=blowjobs' => 'Blowjobs',
                '/videos/?ct=brunette' => 'Brunette',
                '/videos/?ct=camsex' => 'Cam Sex',
                '/videos/?ct=cartoons' => 'Cartoons',
                '/videos/?ct=creampie' => 'Creampie',
                '/videos/?ct=cumshots' => 'Cum Shots',
                '/videos/?ct=dancing' => 'Dancing',
                '/videos/?ct=dp' => 'DP',
                '/videos/?ct=ebony' => 'Ebony',
                '/videos/?ct=feet' => 'Feet',
                '/videos/?ct=fetish' => 'Fetish',
                '/videos/?ct=fisting' => 'Fisting',
                '/videos/?ct=funny' => 'Funny',
                '/videos/?ct=gays' => 'Gays',
                '/videos/?ct=groupsex' => 'GroupSex',
                '/videos/?ct=handjob' => 'Handjob',
                '/videos/?ct=hardcore' => 'Hardcore',
                '/videos/?ct=hd' => 'HD',
                '/videos/?ct=interracial' => 'Interracial',
                '/videos/?ct=jackingoff' => 'Jacking Off',
                '/videos/?ct=latina' => 'Latina',
                '/videos/?ct=lesbians' => 'Lesbians',
                '/videos/?ct=masturbation' => 'Masturbation',
                '/videos/?ct=mature' => 'Mature',
                '/videos/?ct=milf' => 'MILF',
                '/videos/?ct=party' => 'Party',
                '/videos/?ct=pornstars' => 'Porn Stars',
                '/videos/?ct=pov' => 'POV',
                '/videos/?ct=public' => 'Public',
                '/videos/?ct=redhead' => 'Redhead',
                '/videos/?ct=sexybabes' => 'Sexy Babes',
                '/videos/?ct=teen18' => 'Teen18+',
                '/videos/?ct=transexuals' => 'Transexuals'
            ),
            'order' => array('' => 'Newest',
                'or=12&sor=12' => 'Longest',
                'or=2&sor=3' => 'Most Viewed Today',
                'or=2&sor=4' => 'Most Viewed Last Week',
                'or=2&sor=5' => 'Most Viewed Last Month',
                'or=2&sor=6' => 'Most Viewed All Time',
                'lt=4' => 'Being Watched'
            )
        );
    }

}

?>
