<?php

class SiteConfigurationController extends Controller{

	public function actionGetAvailableThemes(){
		$themes=new BThemes();
		$themes=$themes->getAvailableThemes();
		echo serialize($themes);
	}

	public function actionChangeTheme(){
		if(is_numeric($_POST['id']) == true){
			$themes=new BThemes();
			if($themes->changeWebsiteTheme($_POST['id']) == true){
				header('HTTP/1.1 200 OK');
				exit;
			}else{
				header('HTTP/1.1 404 Not Found');
				exit;
			}
		}else{
			header('HTTP/1.1 404 Not Found');
			exit;
		}
	}

	public function actionGetDatabaseConfiguration(){
		$configuration=Configuration::model()->find('section=:section',array(':section'=>'unifiedConfiguration'));
		if($configuration){
			echo $configuration->value;
		}else{
			echo serialize(null);
		}
	}
}

?>
