<?php

class AdminCms2ImagesController extends Controller{

	/**
	 * @return array action filters
	 */
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
			array('allow',
				'users'=>array('@'),
			),
			array('deny', // deny all users
				
				'users'=>array('*'),
			),
		);
	}

	public function init() {
		Yii::app()->theme = 'twitter_fluid'; // You can set it there or in config or somewhere else before calling render() method.
		parent::init();
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id){
		$this->render('view', array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate(){
		$model=new Cms2Images;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Cms2Images'])){
			$model->attributes=$_POST['Cms2Images'];
			if($model->save())
				$this->redirect(array('view', 'id'=>$model->id));
		}

		$this->render('create', array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id){
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Cms2Images'])){
			$model->attributes=$_POST['Cms2Images'];
			if($model->save())
				$this->redirect(array('view', 'id'=>$model->id));
		}

		$this->render('update', array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id){
		if(Yii::app()->request->isPostRequest){
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex(){
		$dataProvider=new CActiveDataProvider('Cms2Images');
		$this->render('index', array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin(){
		$model=new Cms2Images('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cms2Images']))
			$model->attributes=$_GET['Cms2Images'];

		$this->render('admin', array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id){
		$model=Cms2Images::model()->findByPk($id);
		if($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model){
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'cms2-images-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionGetAvailableImages(){
		$this->layout='//layouts/basic';
		$model=new Cms2Images('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cms2Images']))
			$model->attributes=$_GET['Cms2Images'];

		$this->render('_listImagesInGrid', array('model'=>$model,'fceditorChooseImages'=>true));
	}

//	public function actionGetAvailableImagesForArticle(){
//		$images=new CActiveDataProvider('Cms2Images',array('pagination'=>array('pageSize'=>2,
//			'route'=>'//cms2/adminCms2Images/getAvailableImagesForArticle')));
//		$this->renderPartial('getAvailableImagesForArticle', array('dataProvider'=>$images));
//	}

	public function actionGetAvailableImagesForGallery(){
		$this->layout='//layouts/basic';
		$model=new Cms2Images('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cms2Images']))
			$model->attributes=$_GET['Cms2Images'];

		$this->render('_listImagesInGrid', array('model'=>$model));
	}

        
}
