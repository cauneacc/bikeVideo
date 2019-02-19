<?php

class SiteController extends Controller {

	public $layout = 'main';

	public function filters() {
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() {
		return array(
			array('allow', // allow authenticated users to access all actions
				'users' => array('@'),
			),
			array('deny', // deny all users
				'actions' => array('addVideo', 'logout', 'admin', 'update', 'delete'),
				'users' => array('*'),
			),
		);
	}

	public function beforeAction($action) {
		return parent::beforeAction($action);
	}

	public function init() {
//        Yii::app()->themeManager->basePath .= '/twitter_fluid';
//        Yii::app()->themeManager->baseUrl .= '/twitter_fluid';
		Yii::app()->theme = 'twitter_fluid'; // You can set it there or in config or somewhere else before calling render() method.
		parent::init();
	}

	public function actionConfirm() {
		if (isset($_POST['confirm']) || isset($_GET['confirm'])) {
			Yii::app()->user->setState('agreed', true);
			$this->redirect(array('/site/index'));
		}
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError() {
		if ($error = Yii::app()->errorHandler->error) {
			if (Yii::app()->request->isAjaxRequest) {
				echo $error['message'];
			} else {
				$this->render('error', $error);
			}
		}
	}

	public function actionApiError() {
		header('HTTP/1.1 404 Not Found');
		echo 'error';
		Yii::app()->end();
	}

	public function actionAddVideo() {
		$errorMessage = null;
		if (isset($_POST['submit'])) {
			$checkVideo = Yii::app()->db->createCommand('select video_id from {{video}} where url like \'' . mysql_escape_string($_POST['url']) . '%\'');
			$result = $checkVideo->queryAll();
			if (count($result) == 0) {
				parse_str(parse_url($_POST['url'], PHP_URL_QUERY), $aux);
				if ($aux['v']) {
//				$embedCode = '<iframe width="640" height="360" src="http://www.youtube.com/embed/##id##?rel=0" frameborder="0" allowfullscreen></iframe>';
					$embedCode = '<iframe width="853" height="480" src="http://www.youtube.com/embed/##id##?rel=0" frameborder="0" allowfullscreen></iframe>';
					$model = new Video();
					$data = array('title' => $_POST['title'],
						'desc' => $_POST['description'],
						'tags' => explode(',', $_POST['tags']),
						'thumbUrl' => $_POST['thumbUrl'],
						'categories' => $_POST['categories'],
						'embed' => str_replace('##id##', $aux['v'], $embedCode),
						'url' => $_POST['url'],
					);
					$model->add_video($data, false);
				}
			} else {
				$errorMessage = 'Deja exista un videoclip cu url-ul ' . $_POST['url'] . '. Videoclipul nu a fost adaugat';
			}
		}
		$categories = VideoCategories::model()->findAll();
		$model = new Video();
		$tags = '';
		$this->render('createEditVideo', array('categories' => $categories, 'model' => $model, 'tags' => $tags, 'errorMessage' => $errorMessage));
	}

	public function actionCheckUniqueVideoUrl() {
		if (isset($_POST['url'])) {
			$checkVideo = Yii::app()->db->createCommand('select video_id from {{video}} where url like \'' . mysql_escape_string($_POST['url']) . '%\'');
			$result = $checkVideo->queryAll();
			if (count($result) > 0) {
				echo 'error';
			}
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin() {
		$model = new LoginForm;
		// if it is ajax validation request
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		// collect user input data
		if (isset($_POST['LoginForm'])) {
			$model->attributes = $_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if ($model->validate() && $model->login())
				$this->redirect('//site/admin');
		}
		// display the login form
		$this->render('login', array('model' => $model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout() {
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionAdmin() {
		$model = new Video('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Video']))
			$model->attributes = $_GET['Video'];

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) {
		$model = Video::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	public function actionDelete($id) {
		$model = Video::model()->findByPk($id);
		$model->delete();
		$this->redirect('/site/admin');
	}

	public function actionUpdate($id) {
		$model = Video::model()->findByPk($id);
		if (isset($_POST['submit'])) {
			parse_str(parse_url($_POST['url'], PHP_URL_QUERY), $aux);
			if ($aux['v']) {
//				$embedCode = '<iframe width="640" height="360" src="http://www.youtube.com/embed/##id##?rel=0" frameborder="0" allowfullscreen></iframe>';
				$embedCode = '<iframe width="853" height="480" src="http://www.youtube.com/embed/##id##?rel=0" frameborder="0" allowfullscreen></iframe>';
				$data = array('title' => $_POST['title'],
					'desc' => $_POST['description'],
					'tags' => explode(',', $_POST['tags']),
					'thumbUrl' => $_POST['thumbUrl'],
					'categories' => $_POST['categories'],
					'embed' => str_replace('##id##', $aux['v'], $embedCode),
					'url' => $_POST['url'],
				);
				$model->updateVideo($data);
			}
			$this->redirect('//site/admin');
		}

		$categories = VideoCategories::model()->findAll();
		$command = Yii::app()->db->createCommand('select group_concat(t.name) as tags from {{video_tags}} as t inner join {{video_tags_lookup}} as l on (t.tag_id=l.tag_id) where l.video_id=:videoId');
		$command->bindParam(':videoId', $id);
		$tags = $command->queryScalar();
		$command = Yii::app()->db->createCommand('select  cat_id from {{video_category}} where video_id=:videoId');
		$command->bindParam(':videoId', $id);
		$selectedCategories = array();
		$dataReader = $command->query();
		while (($row = $dataReader->read()) !== false) {
			$selectedCategories[] = $row['cat_id'];
		}

		$this->render('createEditVideo', array('categories' => $categories, 'model' => $model, 'tags' => $tags, 'selectedCategories' => $selectedCategories));
	}

}
