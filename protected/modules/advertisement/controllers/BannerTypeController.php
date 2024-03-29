<?php

class BannerTypeController extends Controller
{
	public $layout='//layouts/main';

	public function filters()
	{
		return array(
				'accessControl', 
				);
	}

	public function accessRules()
	{
		return array(
				array('allow',  
					'actions'=>array('index','view'),
					'users'=>array('*'),
					),
				array('allow', 
					'actions'=>array('getOptions', 'create','update'),
					'users'=>array('@'),
					),
				array('allow', 
					'actions'=>array('admin','delete'),
					'users'=>array('admin'),
					),
				array('deny', 
					'users'=>array('*'),
					),
				);
	}

	public function actionView()
	{
		$this->render('view',array(
					'model' => $this->loadModel(),
					));
	}

	public function actionCreate()
	{
		$model = new BannerType;

		$this->performAjaxValidation($model, 'banner-type-form');

		if(isset($_POST['BannerType'])) {
			$model->attributes = $_POST['BannerType'];

			if($model->save()) {

				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array( 'model'=>$model));
	}

	public function actionUpdate()
	{
		$model = $this->loadModel();

		$this->performAjaxValidation($model, 'banner-type-form');

		if(isset($_POST['BannerType']))
		{
			$model->attributes = $_POST['BannerType'];

			if($model->save()) 
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
					'model'=>$model,
					));
	}

	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadModel()->delete();

			if(!isset($_GET['ajax']))
			{
				if(isset($_POST['returnUrl']))
					$this->redirect($_POST['returnUrl']); 
				else
					$this->redirect(array('admin'));
			}
		}
		else
			throw new CHttpException(400,
					Yii::t('app', 'Invalid request. Please do not repeat this request again.'));
	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('BannerType');
		$this->render('index',array(
					'dataProvider'=>$dataProvider,
					));
	}

	public function actionAdmin()
	{
		$model=new BannerType('search');
		$model->unsetAttributes();

		if(isset($_GET['BannerType']))
			$model->attributes = $_GET['BannerType'];

		$this->render('admin',array(
					'model'=>$model,
					));
	}

	public function loadModel() {
		return BannerType::model()->findByPk($_GET['id']);
	}

	protected function performAjaxValidation($model, $form) {
		if(isset($_POST['ajax']) && $_POST['ajax'] == $form) {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
