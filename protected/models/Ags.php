<?php

/**
 * Ags
 * */
class Ags{

	public static function searchValue(){
		if(isset($_GET['title']))
			echo $_GET['title'];
	}

	public static function hasModule($module){
		if(!array_key_exists($module, Yii::app()->modules))
			return false;

		if(isset(Yii::app()->modules[$module]['enabled']) &&
			Yii::app()->modules[$module]['enabled'] == false)
			return false;
		return true;
	}
	public static function t($string, $params = array()){
		return Yii::t('ags', $string, $params);
	}

	public function image($filename, $alt = ''){
		return CHtml::image(Yii::app()->theme->baseUrl.'/images/style/'.$filename, $alt);
	}
	/* set a flash message to display after the request is done */

	public static function setFlash($message){
		$_SESSION['ags_message']=Yum::t($message);
	}

	public static function hasFlash(){
		return isset($_SESSION['ags_message']);
	}

	/* retrieve the flash message again */

	public static function getFlash(){
		$message=$_SESSION['ags_message'];
		unset($_SESSION['ags_message']);
		return $message;
	}

	public static function renderFlash(){
		if(Ags::hasFlash()){
			echo '<div class="info">';
			echo Ags::getFlash();
			echo '</div>';
			Yii::app()->clientScript->registerScript('fade', "
					setTimeout(function() { $('.info').fadeOut('slow'); }, 5000);	
					");
		}
	}

}

?>
