<?php

class BThemes{

	protected $availableThemes=array();

	function getAvailableThemes(){
		$themes=array();
		$dir=YiiBase::getPathOfAlias('webroot.themes');
		if(is_dir($dir) == true){
			$dh=opendir($dir);
			if($dh){

				while(($file=readdir($dh)) !== false){
					if($file != '..' and $file != '.'){
						if($dir.DIRECTORY_SEPARATOR.is_dir($file) == true){
							if(is_file($dir.DIRECTORY_SEPARATOR.$file.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'style.css') == true){
								$text=@file_get_contents($dir.DIRECTORY_SEPARATOR.$file.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'style.css');
								if($text !== false){
									$aux=$this->parseThemeCssHeader($text);
									if($aux != false){
										if($file==Yii::app()->theme->name){
											$aux['selected']=true;
										}
										$themes[]=$aux;
										$this->availableThemes[]=$file;
									}
								}
							}
						}
					}
				}

				closedir($dh);
			}
		}
		return $themes;
	}

	function changeWebsiteTheme($themeId){
		if(isset($this->availableThemes[$themeId])){
			$configFile=Yii::getPathOfAlias('application.config').DIRECTORY_SEPARATOR.'main.php';
			if(is_writable($configFile)){
				$config=file_get_contents($configFile);
				$start=strpos($config, "'layout'");
				$end=strpos($config,',',$start+8);
				if($start!=false and $end!=false){
					$config=substr($config, 0,$start)."'layout'=>'".$this->availableThemes[$themeId]."'".substr($config, $end);
					return file_put_contents($configFile,$config);
				}else{
					throw new CException(Yii::t('app', 'Could not parse config file'));
					return false;
				}
			}else{
				throw new CException(Yii::t('app', 'Config file {file} is not writeable', array('{file}'=>$configFile)));
				return false;
			}
		}else{
			return false;
		}
	}

	protected function parseThemeCssHeader($text){
		$r=array();
		$start=strpos($text, '/*');
		if($start != false){
			$end=strpos($text, '*/', $start + 2);
			if($end != false){
				$header=substr($text, $start + 2, $end - $start - 2);
				$rows=explode("\n", $header);
				if(count($rows) == 1){
					$rows=explode("\r", $header);
				}
				$max=count($rows);
				for($i=0; $i < $max; $i++){
					if(trim($rows[$i]) != ''){
						$rows[$i]=trim($rows[$i]);
						$end=strpos($rows[$i], ':');

						if($end != false){
							$r[str_replace(' ', '', substr($rows[$i], 0, $end))]=substr($rows[$i], $end + 1);
						}else{
							$r['Comments']=$r['Comments'].$rows[$i];
						}
					}
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
		return $r;
	}

	protected function getThemePreviewsUrl($name){
		$r=array();
		$themePreviewPath=Yii::getPathOfAlias('webroot.themes.'.$name.'.images').DIRECTORY_SEPARATOR.'themePreview.jpg';
		$themePreviewThumbnailPath=Yii::getPathOfAlias('webroot.themes.'.$name.'.images').DIRECTORY_SEPARATOR.'themePreviewThumbnail.jpg';
		if(is_file($themePreviewPath)){
			$r['largePreview']=Yii::app()->baseUrl.'themes/'.$name.'/images/themePreview.jpg';
		}
		if(is_file($themePreviewThumbnailPath)){
			$r['thumbnailPreview']=Yii::app()->baseUrl.'themes/'.$name.'/images/themePreviewThumbnail.jpg';
		}

	}


}

?>
