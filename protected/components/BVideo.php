<?php
//Yii::import('application.components.BImage');
class BVideo{

	public function __construct(){
		$this->basePath=realpath(Yii::getPathOfAlias('application').DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'videos'.DIRECTORY_SEPARATOR);
	}
	static function createVideoPartialPath($id){
		return floor($id/20000).DIRECTORY_SEPARATOR.$id;
	}
        
	static function createVideoPartialUrl($id){
		return floor($id/20000).'/'.$id;
	}
        
        
	public function chooseVideoDirectory($id){
		return $this->basePath.DIRECTORY_SEPARATOR.BVideo::createVideoPartialPath($id).DIRECTORY_SEPARATOR;
	}


	public function createFolderStructure($path,$mode=0777){
		if(file_exists($path)==false){
			if(strpos($path, $this->basePath)===0){
				if(mkdir($path,$mode,true)==false){
					Yii::log(
						Yii::t('BCrawlers','Error while trying to create folder structure {path}. Error occured while trying to create folder {workingPath}',
							array('{path}'=>$path,'{workingPath}'=>$currentFile)),'error','extensions.crawlers');
					return false;
				}
			}else{
				Yii::log(
					Yii::t('BCrawlers','Stopped trying to create folder structure {path} because it was outsite of video thumbs base path {basePath}',
						array('{path}'=>$path,'{basePath}'=>$this->basePath)),'error','extensions.crawlers');
				return false;
			}

		}
		return true;
	}
}
?>
