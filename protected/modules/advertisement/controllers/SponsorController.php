<?php

class SponsorController extends CController{
	public function filters(){
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules(){
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array( 'delete', 'create', 'index', 'update'),
				'allow'=>'admin'
			),
			array('deny', // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex(){
		$dataProvider=new CActiveDataProvider('AdvertisingSponsor');
		$this->render('index', array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionDelete(){
		if(Yii::app()->request->isPostRequest){
			$this->loadModel()->delete();
			if(!isset($_GET['ajax'])){
				if(isset($_POST['returnUrl'])){
					$this->redirect($_POST['returnUrl']);
				}else{
					$this->redirect(array('index'));
				}
			}
		}else{
			throw new CHttpException(400,
				Yii::t('app', 'Invalid request. Please do not repeat this request again.'));
		}
	}

	public function actionUpdate(){
		$model=$this->loadModel();
		$this->performAjaxValidation($model, 'advertising-sponsor-form');
		if(isset($_POST['AdvertisingSponsor'])){
			$model->attributes=$_POST['AdvertisingSponsor'];
			if($model->save()){
				$this->redirect(array('index'));
			}
		}
		$this->render('update', array(
			'model'=>$model,
		));
	}

	public function loadModel(){
		if(isset($_GET['id'])){
			return AdvertisingSponsor::model()->findByPk($_GET['id']);
		}
	}

	public function actionCreate(){
		$model=new AdvertisingSponsor;
		$this->performAjaxValidation($model, 'advertising-sponsor-form');
		if(isset($_POST['AdvertisingSponsor'])){
			$model->attributes=$_POST['AdvertisingSponsor'];
			if($model->save()){
				$this->redirect(array('index'));
			}
		}
		$this->render('create', array('model'=>$model));
	}

	protected function performAjaxValidation($model, $form){
		if(isset($_POST['ajax']) && $_POST['ajax'] == $form){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


}
