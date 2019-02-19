<?php
class ArticlesModule extends CWebModule{

	public function beforeControllerAction($controller, $action){
		if(parent::beforeControllerAction($controller, $action)){
			$controller->layout='//layouts/main';
			return true;
		}
		else
			return false;
	}

}
