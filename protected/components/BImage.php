<?php
class BImage{
	const dirMultiplicator=20000;

	function __construct(){
		$this->basePath=realpath(Yii::getPathOfAlias('application').DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'videos'.DIRECTORY_SEPARATOR.'tmb');
		$this->tmpBasePath=YiiBase::getPathOfAlias('application.runtime.tmp.downloads');
	}
	public function chooseVideoThumbnailDirectory($id){
		return $this->basePath.DIRECTORY_SEPARATOR.BImage::createVideoThumbPartialPath($id);
	}

	static function createVideoThumbPartialPath($id){
		return floor($id/20000).DIRECTORY_SEPARATOR.$id;
	}

	static function createVideoThumbPartialUrl($id){
		return floor($id/20000).'/'.$id;
	}
        
	public function getTmpFilePath(){
		return $this->tmpBasePath.DIRECTORY_SEPARATOR.time().'_'.rand(0, 99999);
	}

	public function createFolderStructure($path,$mode=0777){
		if(file_exists($path)==false){
			$error=false;
			if(strpos($path, $this->basePath)===0){
				$path=substr($path, strlen($this->basePath)+1);
				$pieces=explode(DIRECTORY_SEPARATOR, $path);
				if(is_array($pieces)==true){
					$i=0;
					$max=count($pieces);
					$basePath=$this->basePath;
					while($i<$max and $error==false){
						if(trim($pieces[$i])!=''){
							
							$currentFile=$basePath.DIRECTORY_SEPARATOR.trim($pieces[$i]);
							if(file_exists($currentFile)==false){
								if(mkdir($currentFile,$mode)==false){
									$error=true;
								}else{
									$basePath=$currentFile;
								}
							}else{
								$basePath=$currentFile;
							}
						}
						$i=$i+1;
					}
				}
				if($error==true){
					Yii::log(
						Yii::t('BCrawlers','Error while trying to create folder structure {path}. Error occured while trying to create folder {workingPath}',
							array('{path}'=>$path,'{workingPath}'=>$currentFile)),'error','extensions.crawlers');
					return false;
				}else{
					return true;
				}
			}else{
				Yii::log(
					Yii::t('BCrawlers','Stopped trying to create folder structure {path} because it was outsite of video thumbs base path {basePath}',
						array('{path}'=>$path,'{basePath}'=>$this->basePath)),'error','extensions.crawlers');
				return false;
			}
		}else{
			return true;
		}
	}

}
