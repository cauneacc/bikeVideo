<?php

Yii::import('application.modules.api.libraries.BHash');

class ApiModule extends CWebModule {

	public function init() {
		$this->setImport(array(
			'api.libraries.*'
		));
		Yii::app()->setComponents(array(
			'errorHandler' => array(
				'errorAction' => 'site/apiError',
			),));
	}

	public function beforeControllerAction($controller, $action) {
		if (parent::beforeControllerAction($controller, $action)) {
			$controller->layout = '';
			$hasher = new BHash();
			if ($hasher->checkHash($_GET, $_POST) == true) {
				return true;
			} else {
				header('HTTP/1.1 401 Unauthorized');
				exit('not allowed');
			}
		} else {
			return false;
		}
	}

	public function getDbConfigForAvailableSites() {
		$sitesAvailable = require(dirname(__FILE__) . '/../../config/availableSites.php');
		$results = array();
		foreach ($sitesAvailable as $site) {
			$configFilePath = dirname(__FILE__) . '/../../config/' . $site . '/applicationDb.php';
			if (is_file($configFilePath)) {
				$config = require($configFilePath);
				$results[$site]=$config;
			}
		}
		return $results;
	}

}
