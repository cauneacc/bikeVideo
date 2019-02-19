<?php
/**
 *controller only used to display a not found page. This controllers is set in the configuration 
 * as the default controller for the agsi main configuration. This configuration is used to 
 * receive api calls to create a new site. This configuration should only respond to
 * api calls 
 */
class NotFoundController extends Controller{
	public function actionIndex(){
		header("HTTP/1.1 404 Not Found");
		echo Yii::t('app','Page not found');
	}

}

?>
