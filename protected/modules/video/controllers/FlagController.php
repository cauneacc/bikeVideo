<?php

class FlagController extends Controller{

	public function actionIndex(){
		if(isset($_POST['videoId'])){
			if(is_numeric($_POST['videoId'])){
				$message='Video Id: '.strip_tags($_POST['videoId'])."\n";
				$message=$message.'Name: '.strip_tags($_POST['name'])."\n";
				$message=$message.'Email: '.strip_tags($_POST['email'])."\n";
				$message=$message.'Reason: '.strip_tags($_POST['type'])."\n";
				$message=$message.'Description: '.strip_tags($_POST['description'])."\n";
				mail('cristianftataru@yahoo.com', 'Video reported on '.Yii::app()->name, $message);
				Video::model()->updateByPk($_POST['videoId'], array('flagged'=>1));
				header('HTTP/1.1 200 OK');
				Yii::app()->end();
			}
		}
		header('HTTP/1.1 404 Not Found');
	}

}

?>
