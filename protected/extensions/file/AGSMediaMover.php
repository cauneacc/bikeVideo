<?php

class AGSMediaMover{

	public function moveThumbnails($sourcePath, $videoId, $numberOfThumbnails, $extension='.jpg'){
		return $this->moveThumbnailsLocalFilesystem($sourcePath, $videoId, $numberOfThumbnails, $extension);
	}

	public function deleteThumbnails($videoId){
		return $this->deleteThumbnailsLocalFilesystem($videoId);
	}

	protected function moveThumbnailsLocalFilesystem($sourcePath, $videoId, $numberOfThumbnails, $extension='.jpg'){
		if(substr($sourcePath, -1) !== DIRECTORY_SEPARATOR){
			$sourcePath=$sourcePath.DIRECTORY_SEPARATOR;
		}
		$bImage=new BImage();
		$destinationPath=$bImage->chooseVideoThumbnailDirectory($videoId);
		if($bImage->createFolderStructure($destinationPath) == true){
		 echo __FILE__.' '.__LINE__.'<br/>';
			$i=1;
			while($i <= $numberOfThumbnails){
				$source=$sourcePath.$i.$extension;
				if($this->moveFile($source, $destinationPath.DIRECTORY_SEPARATOR.$i.$extension) == false){
				 echo __FILE__.' '.__LINE__.'<pre>';
				 var_dump($source);
				 var_dump($destinationPath.DIRECTORY_SEPARATOR.$i.$extension);
				 echo '</pre>';
				 echo __FILE__.' '.__LINE__.'<br/>';
					return false;
				}
				$i=$i + 1;
			}

			return true;
		}else{
		 echo __FILE__.' '.__LINE__.'<br/>';
			return false;
		}
	}

	public function moveFlv($sourcePath, $videoId){
		return $this->moveFlvLocalFilesystem($sourcePath, $videoId);
	}

	protected function moveFlvLocalFilesystem($sourcePath, $videoId){
		$bVideo=new BVideo();
		$path=$bVideo->chooseVideoDirectory($videoId);
		if($bVideo->createFolderStructure($path) == true){
			return $this->moveFile($sourcePath, $path.DIRECTORY_SEPARATOR.$videoId.'.flv');
		}else{
			return false;
		}
	}

	protected function moveFile($source, $destination){
		if(is_file($source) == true){
			if(rename($source, $destination) == false){
				Yii::log(
						Yii::t('app', 'Could not move file {path} to {destinaton}',
							array('{path}'=>$source, '{destination}'=>$destination)), 'error', 'extensions.file');
				return false;
			}
		}else{
			Yii::log(
					Yii::t('app', 'Could not find file {path}',
						array('{path}'=>$source)), 'error', 'extensions.file');
			return false;
		}
		return true;
	}

	protected function deleteThumbnailsLocalFilesystem($videoId){
		$bImage=new BImage();
		$destinationPath=$bImage->chooseVideoThumbnailDirectory($videoId);
		if(is_dir($destinationPath)==true){
			$contents=scandir($destinationPath);
			foreach($contents as $content){
				if($content!='..' and $content!='.'){
					if(is_file($destinationPath.DIRECTORY_SEPARATOR.$content)==true){
						unlink($destinationPath.DIRECTORY_SEPARATOR.$content);
					}
				}
			}
			return rmdir($destinationPath);
		}else{
			Yii::log(
					Yii::t('app', 'Path {path} is not a folder',
						array('{path}'=>$source)), 'error', 'extensions.file');
			return false;
		}
	}

}

?>
