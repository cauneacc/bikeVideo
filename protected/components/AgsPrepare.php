<?php

class AgsPrepare extends CApplicationComponent
{
	private $languages = array();

	public function init()
	{
//		$this->setLanguage();
//		$this->ageConfirmation();
//		$this->syncModules();
	}

	public function syncModules() {
		$config = Configuration::model()->find("section = 'modules'");

		if($config) {
			$modules = Yii::app()->modules;
			foreach($config->value as $module => $enabled) {
				if(!$enabled)
					$modules[$module]['enabled'] = false;
			}
			Yii::app()->setModules($modules);
		}
	}

	public function ageConfirmation() {
		if(!Yii::app()->user->getState('agreed')
				&& strpos(Yii::app()->request->url, 'confirm') === false
				&& strpos(Yii::app()->request->url, 'rest') === false
				&& strpos(Yii::app()->request->url, 'api') === false
				&& strpos(Yii::app()->request->url, 'sendCurl') === false
				&& strpos(Yii::app()->request->url, 'language') === false) {
			Yii::import('application.controllers.SiteController');
			$controller = new SiteController('site');
			$controller->layout = 'enter';
			$controller->render('age_confirmation');	
			Yii::app()->end();
		}

	}

	/*
	 * checks if langauge parameter is set in cookie
	 */
	private function setLanguage() {
//		Yii::app()->language = @Yii::app()->user->getState('lang');
	}
}
