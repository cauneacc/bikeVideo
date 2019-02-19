<?php

class MassEmbedCommand extends CConsoleCommand{
	private static $availableCrawlers=array('xvideos','redtube','shufuni','tnaflix');
	
	public function run($args){
		Yii::import('ext.crawlers.BCrawler');
		if($args[0] == '--site=all'){

		}else{
			foreach($args as $arg){
				if(substr($arg, 0, 7) === '--site='){
					switch(substr($arg, 7)){
						case 'xvideos':
							$this->startXvideos();
							break;
						case 'redtube':
							$this->startRedtube();
							break;
						case 'shufuni':
							$this->startShufuni();
							break;
						case 'tnaflix':
							$this->startTnaflix();
							break;

						default:
							$message=Yii::t('BCrawlers', 'No crawler found for this website');
							Yii::log($message, 'info', 'extensions.crawlers');
							echo $message.PHP_EOL;
							break;
					}

				}
			}
		}
	}

	protected function startRedtube(){
		Yii::import('ext.crawlers.BRedtube');
		$crawler=new BRedtube();
		$crawler->getVideos();
	}

	protected function startXvideos(){
		Yii::import('ext.crawlers.BXvideos');
		$crawler=new BXvideos();
		$crawler->getVideos();
	}

	protected function startShufuni(){
		Yii::import('ext.crawlers.BShufuni');
		$crawler=new BShufuni();
		$crawler->getVideos();
	}

	protected function startTnaflix(){
		Yii::import('ext.crawlers.BTnaflix');
		$crawler=new BTnaflix();
		$crawler->getVideos();
	}

	public static function listCrawlers(){
		$r=array();
		foreach(self::$availableCrawlers as $crawler){
			if(is_file(Yii::getPathOfAlias('ext.crawlers.B'.ucfirst($crawler)).'.php')==true){
				$r[]=$crawler;
			}
		}
		return $r;
	}
}

?>
