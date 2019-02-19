<?php
class TextAdTemplatesController extends CController{
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
				'actions'=>array('create','index','update'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex(){
		$dataProvider=new CActiveDataProvider('AdvertisingTemplate');
		$this->render('index', array(
			'dataProvider'=>$dataProvider,
		));
	}
	public function actionCreate(){
		$model=new AdvertisingTemplate;
		$this->performAjaxValidation($model, 'advertising-template-form');
		if(isset($_POST['AdvertisingTemplate'])){
			$model->attributes=$_POST['AdvertisingTemplate'];
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

	public function actionUpdate(){
		$model=$this->loadModel();
		$this->performAjaxValidation($model, 'advertising-template-form');
		if(isset($_POST['AdvertisingTemplate'])){
			$model->attributes=$_POST['AdvertisingTemplate'];
			$model->validate();
			if(!$model->hasErrors() && $model->save()){
				$this->redirect(array('index'));
			}
		}

		$this->render('update', array('model'=>$model));
	}
	
	public function loadModel(){
		return AdvertisingTemplate::model()->findByPk($_GET['id']);
	}

}
?>
