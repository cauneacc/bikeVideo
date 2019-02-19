<?php
class BConfigurationHelper{

	function saveConfigurationToFile($value,$section){
		$path=YiiBase::getPathOfAlias('application.config.custom.'.$section).'.php';
		$value=unserialize($value);

		$value='<?php return '.var_export($value,true).'?>';
		if(@file_put_contents($path,$value)==false){
			Yii::log(Yii::t('app','Could not write video configuration to file {file}',array('{file}'=>$path)), 'error');
			return false;
		}else{
			chmod($path, 0666);
			return $this->createMasterConfigurationFile();
		}

	}

	protected function createMasterConfigurationFile(){
		$path=YiiBase::getPathOfAlias('application.config.custom.unifiedConfiguration').'.php';
		$dir=YiiBase::getPathOfAlias('application.config.custom');
		if (is_dir($dir)==true) {
			$dh = opendir($dir);
			if ($dh) {
				$configuration=array();
				while (($file = readdir($dh)) !== false) {
					if(substr($file,-4)==='.php' and $file!=='unifiedConfiguration.php'){
						$aux=require_once($dir.DIRECTORY_SEPARATOR.$file);
						if(is_array($aux)==true){
							$configuration=array_merge($configuration,$aux);
						}
					}
				}

				closedir($dh);
			}
		}
		$configuration='<?php return '.var_export($configuration,true).'?>';
		if(@file_put_contents($path,$configuration)==false){
			Yii::log(Yii::t('app','Could not write unified configuration to file {file}',array('{file}'=>$path)), 'error');
			return false;
		}else{
			return true;
		}

	}
}
?>
