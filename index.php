<?php
date_default_timezone_set('Europe/Budapest');
if (isset($_SERVER['HTTP_HOST'])) {
	$availableSites= require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'protected/config/availableSites.php');
	if (in_array($_SERVER['HTTP_HOST'], $availableSites)) {
		$yii = dirname(__FILE__) . '/protected/framework/yii.php';
		$config = dirname(__FILE__) . '/protected/config/'.$_SERVER['HTTP_HOST'].'/main.php';
		// remove the following lines when in production mode
		defined('YII_DEBUG') or define('YII_DEBUG', true);
		// specify how many levels of call stack should be shown in each log message
		defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
		require_once($yii);
		error_reporting(E_ALL & ~E_NOTICE);
		Yii::createWebApplication($config)->run();
	} else {
		header('HTTP/1.0 404 Not Found');
		echo 'Site or page doesn\'t exist';
	}
}