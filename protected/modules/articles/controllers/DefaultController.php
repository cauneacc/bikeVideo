<?php

/**
 * controller only used to display a not found page. This controllers is set in the configuration 
 * as the default controller for the agsi main configuration. This configuration is used to 
 * receive api calls to create a new site. This configuration should only respond to
 * api calls 
 */
class DefaultController extends Controller {

	public function actionIndex() {
		if (isset($_GET['slug'])) {
			$filePath = Yii::getPathOfAlias('webroot.articles.' . str_replace('.', '', $_GET['slug'])) . DIRECTORY_SEPARATOR . 'index.html';
			if (is_file($filePath)) {
				$text = file_get_contents($filePath);
				$this->render('index', array('text' => $text));
			} else {
				throw new CHttpException(404);
			}
		} else {
			throw new CHttpException(404);
		}
	}

}

?>
