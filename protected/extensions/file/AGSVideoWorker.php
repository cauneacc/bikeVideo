<?php

class AGSVideoWorker{

	public $errors;
	public $rawFileExtension;
	public $finalPath;
	public $currentPath;

	function __construct(){
		Yii::import('ext.file.AGSVideoConvertor');
		Yii::import('ext.file.AGSMediaMover');
	}

	function convertVideo($videoId){
		$this->errors=null;
		if(empty($_FILES['file']['name']) == false){
			$this->rawFileExtension=pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
			$this->finalPath=Yii::getPathOfAlias('webroot.videos.'.BVideo::createVideoPartialPath($videoId)).DIRECTORY_SEPARATOR.$videoId.'.flv';
			if($this->moveUploadedFile() == true){
				return $this->handleVideoActions($videoId);
			}else{
				return false;
			}
		}elseif(empty($_POST['fileUrl']) == false){
			$this->finalPath=Yii::getPathOfAlias('webroot.videos.'.BVideo::createVideoPartialPath($videoId)).DIRECTORY_SEPARATOR.$videoId.'.flv';
			$this->rawFileExtension=pathinfo($_POST['fileUrl'], PATHINFO_EXTENSION);
			if($this->downloadFile($_POST['fileUrl']) == true){
				return $this->handleVideoActions($videoId);
			}else{
				$this->manageMessages('Couldn\'t download {url} to {file}', array('{url}'=>$_POST['fileUrl'], '{file}'=>$this->currentPath), 'error');
				return false;
			}
		}else{
			$this->manageMessages('No file to convert was received', null, 'error');
		}
	}

	protected function handleVideoActions($videoId){
		if($this->rawFileExtension === 'flv' and Yii::app()->params['convertSourceFlv'] == 0){
			$mover=new AGSMediaMover();
			if($this->extractAndMoveThumbnails($this->currentPath, $videoId) == true){
				return $mover->moveFlv($this->currentPath, $videoId);
			}else{
				return false;
			}
		}else{
			$aux=$this->extractAndMoveThumbnails($this->currentPath, $videoId);
			if($aux){
				return $this->convertFile($this->currentPath, $videoId);
			}else{
				return false;
			}
		}
	}

	protected function convertFile($filePath, $videoId){
		$convertor=new AGSVideoConvertor($this->getVideoConvertorConfiguration());
		$info=pathinfo($filePath);
		$convertor->load($filePath);

		if($convertor->toFlv($filePath, $info['dirname'].DIRECTORY_SEPARATOR.$info['filename'].'.flv') == true){
			$mover=new AGSMediaMover();
			if($mover->moveFlv($info['dirname'].DIRECTORY_SEPARATOR.$info['filename'].'.flv', $videoId) == true){
				if(unlink($filePath) == true){
					return true;
				}
			}
		}
		return false;
	}

	protected function extractAndMoveThumbnails($filePath, $videoId){
		$convertor=new AGSVideoConvertor($this->getVideoConvertorConfiguration());
		$convertor->load($filePath);
		$tmpDir=Yii::getPathOfAlias('application.runtime.tmp').DIRECTORY_SEPARATOR.rand(1, 9999).DIRECTORY_SEPARATOR;
		if(mkdir($tmpDir, 0777) == true){
			$thumbsExtracted=$convertor->extractThumbs($tmpDir, Yii::app()->params['numberOfThumbsToExtract']);
			$mover=new AGSMediaMover();
			$r=$mover->moveThumbnails($tmpDir, $videoId, $thumbsExtracted);
			if(rmdir($tmpDir) == false){
				$this->manageMessages('Couldn\'t delete folder {path}', array('{path}'=>$tmpDir), 'error');
				return false;
			}
			return $r;
		}else{
			$this->manageMessages('Couldn\'t create folder {path}', array('{path}'=>$tmpDir), 'error');
			return false;
		}
	}

	public function extractThumbnails($filePath, $targetDirectory, $numberOfThumbs){
		$convertor=new AGSVideoConvertor($this->getVideoConvertorConfiguration());
		$convertor->load($filePath);
		if(is_dir($targetDirectory) == false){
			if(mkdir($targetDirectory, 0777) == true){
				$thumbsExtracted=$convertor->extractThumbs($targetDirectory, $numberOfThumbs);
				return $thumbsExtracted;
			}else{
				$this->manageMessages('Couldn\'t create folder {path}', array('{path}'=>$targetDir), 'error');
				return false;
			}
		}else{
			$thumbsExtracted=$convertor->extractThumbs($targetDirectory, $numberOfThumbs);
			return $thumbsExtracted;
		}
	}

	protected function getVideoConvertorConfiguration(){
		return array('ffmpegPath'=>Yii::app()->params['ffmpegPath'],
			'audioSampleRate'=>Yii::app()->params['audioSampleRate'],
			'audioBitrate'=>Yii::app()->params['audioBitrate'],
			'framesPerSecond'=>Yii::app()->params['framesPerSecond'],
			'resizeVideo'=>Yii::app()->params['resizeVideo'],
			'resizeVideoWidth'=>Yii::app()->params['resizeVideoWidth'],
			'resizeVideoHeight'=>Yii::app()->params['resizeVideoHeight'],
			'videoThumbWidth'=>Yii::app()->params['videoThumbWidth'],
			'videoThumbHeight'=>Yii::app()->params['videoThumbHeight'],
			'tmpDir'=>Yii::getPathOfAlias('application.runtime.tmp'),
			'hdResizeVideo'=>Yii::app()->params['hdResizeVideo'],
			'hdResizeVideoWidth'=>Yii::app()->params['hdResizeVideoWidth'],
			'hdResizeVideoHeight'=>Yii::app()->params['hdResizeVideoHeight'],
		);
	}

	protected function moveUploadedFile(){
		$this->currentPath=$this->getTemporaryPath();
		if(move_uploaded_file($_FILES['file']['tmp_name'], $this->currentPath)){
			return true;
		}else{
			$this->manageMessages('Couldn\'t move uploaded file to {path}', array('{path}'=>$this->currentPath), 'error');
			return false;
		}
	}

	protected function downloadFile($url){
		Yii::import('ext.crawlers.libraries.BCurl');
		$this->currentPath=$this->getTemporaryPath();
		return BCurl::file($url, $this->currentPath);
	}

	protected function getTemporaryPath(){
		return Yii::getPathOfAlias('application.runtime.tmp.downloads').DIRECTORY_SEPARATOR.rand(0, 9999).'.'.$this->rawFileExtension;
	}

	protected function manageMessages($message, $variables=null, $level='info'){
		$aux=Yii::t('app', $message, $variables);
		Yii::log($aux, 'error', 'extensions.file');
		$this->errors[]=$aux;
	}

	function convertVideoAlreadyOnServer($videoFilePath, $temporaryThumbnailFolder, $numberOfthumbnails, $videoId){
		$this->errors=null;
		if(is_file($videoFilePath) == true){
			if(is_readable($videoFilePath) and is_writable($videoFilePath)){
				$this->rawFileExtension=pathinfo($videoFilePath, PATHINFO_EXTENSION);
				$this->finalPath=Yii::getPathOfAlias('webroot.videos.'.BVideo::createVideoPartialPath($videoId)).DIRECTORY_SEPARATOR.$videoId.'.flv';
				$this->currentPath=$videoFilePath;

				$mover=new AGSMediaMover();
				if($this->rawFileExtension === 'flv' and Yii::app()->params['convertSourceFlv'] == 0){

					$r=$mover->moveThumbnails($temporaryThumbnailFolder, $videoId, $numberOfthumbnails);
					if($r == true){
						if(rmdir($temporaryThumbnailFolder) == false){
							$this->manageMessages('Couldn\'t delete folder {path}', array('{path}'=>$temporaryThumbnailFolder), 'error');
						}
						return $mover->moveFlv($this->currentPath, $videoId);
					}else{
						$mover->deleteThumbnails($videoId);
						return false;
					}
				}else{
					$r=$mover->moveThumbnails($temporaryThumbnailFolder, $videoId, $numberOfthumbnails);
					if($r){
						if(rmdir($temporaryThumbnailFolder) == false){
							$this->manageMessages('Couldn\'t delete folder {path}', array('{path}'=>$temporaryThumbnailFolder), 'error');
						}

						return $this->convertFile($this->currentPath, $videoId);
					}else{
						$mover->deleteThumbnails($videoId);
						return false;
					}
				}

				return $this->handleVideoActions($videoId);
			}else{
				$this->manageMessages('The user under which this application runs does not have read and write right to the file to be converted', null, 'error');
				return false;
			}
		}else{
			$this->manageMessages('The file to be convert does not exist', null, 'error');
			return false;
		}

	}
        
	public function downloadFlv($url, $videoId){
		$bVideo=new BVideo();
		$path=$bVideo->chooseVideoDirectory($videoId);
		if($bVideo->createFolderStructure($path) == true){
			exec('wget -O '.escapeshellarg($paths.DIRECTORY_SEPARATOR.$videoId.'.flv').' '.escapeshellarg($url).'  > /dev/null 2>&1 &');
			return  true;
		}else{
			return false;
		}
	}

}

?>
