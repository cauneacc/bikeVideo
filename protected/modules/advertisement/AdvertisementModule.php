<?php

class AdvertisementModule extends CWebModule
{
	public $adminLayout = '//layouts/admin';
	public $imagePath = '/images/banner/';

	public function init()
	{
		Yii::app()->theme = 'classic';
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'advertisement.models.*',
			'advertisement.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{

		if(parent::beforeControllerAction($controller, $action))
		{
			$controller->layout = Ad::module()->adminLayout;
			return true;
		}
		else
			return false;
	}
}
