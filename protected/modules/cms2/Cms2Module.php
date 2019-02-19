<?php

class Cms2Module extends CWebModule {

	public function init() {
		$this->setImport(array(
			'cms2.models.*',
		));
	}

	public function beforeControllerAction($controller, $action) {
		$controller->layout = '//layouts/main';
		if (parent::beforeControllerAction($controller, $action)) {
			return true;
		} else {
			return false;
		}
	}

}
