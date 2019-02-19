<?php

class ManageController extends Controller {

	public function actionContact() {
		require_once(dirname(__FILE__) . '/../../../vendors/recaptchalib.php');
		$this->pageTitle = Yii::t('app', 'contact');
		if ($_POST['submit']) {
			$resp = recaptcha_check_answer(Yii::app()->params['recaptchaPrivateKey'], $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

			if (!$resp->is_valid) {
				
				$this->render('contact', array(
					'recaptchaHtml' => recaptcha_get_html(Yii::app()->params['recaptchaPublicKey']),
					'title' => $_POST['title'],
					'email' => $_POST['email'],
					'message' => $_POST['message'],
					'recaptchaResult' => false,
					'browseTitle' => $this->pageTitle));
			} else {
				mail('webmaster@addictedtocycling.com', 'Contact form submission', $_POST['title'].' from '.$_POST['email'].' body '.$_POST['message']);
				$this->render('contact', array(
					'success' => true,
					'browseTitle' => $this->pageTitle));
			}
		} else {
			$this->render('contact', array(
				'recaptchaHtml' => recaptcha_get_html(Yii::app()->params['recaptchaPublicKey']),
				'browseTitle' => $this->pageTitle));
		}
	}

}