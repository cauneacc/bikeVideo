<?php

class AdvertisingCampaignController extends Controller{

	public $layout='//layouts/main';

	public function filters(){
		return array(
			'accessControl',
		);
	}

	public function accessRules(){
		return array(
			array('allow',
				'actions'=>array('index', 'view', 'redirect'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('getOptions', 'create', 'update', 'getPrice'),
				'users'=>array('@'),
			),
			array('allow',
				'actions'=>array('admin', 'delete', 'check'),
				'users'=>array('admin'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	public function loadModel(){
		return AdvertisingCampaign::model()->findByPk($_GET['id']);
	}

	public function actionView(){
//		$model=$this->loadModel();
		$model=AdvertisingCampaign::model()->with('advertisingSponsor')->findByPk($_GET['id']);
		$this->render('view', array(
			'model'=>$model
		));
	}

	public function actionRedirect($id = null, $company_id = null){
		if($id || $company_id){
			$advert=AdvertisingCampaign::model()->findByPk($_GET['id']);
			if($advert){
				$visit=UserVisiting::model()->find('users_id = :uid and advertising_campaign_id = :cid', array(
						':uid'=>Yii::app()->user->id,
						':cid'=>$advert->id));

				if($visit){
					$clicks=$visit->count_clicked;
					$clicks++;
					$visit->count_clicked=$clicks;
					$visit->save();
				}

				if($company_id){
					$this->redirect(array('/company/view', 'id'=>$company_id));
				}else if($id){
					$target=$advert->url_link;
					echo '<script type="text/javascript">window.location = "'.$target.'";</script>';
				}
			}
		}
	}

	public function actionCreate(){
		$model=new AdvertisingCampaign;
		$this->performAjaxValidation($model, 'advertising-campaign-form');
		if(isset($_POST['AdvertisingCampaign'])){
			if($model->createNew($_POST['AdvertisingCampaign'])){
				$this->redirect(array('//advertisement/advertisingCampaign/view', 'id'=>$model->id));
			}
		}
		if($model->start_time === null){
			$model->start_time=time();
		}
		if($model->url_link === null){
			$model->url_link='http://www.';
		}
		if(empty($model->end_time)){
			$model->end_time=mktime(0, 0, 0, 3, 0, 2040);
		}
		$this->render('create', array('model'=>$model));
	}



	public function actionUpdate(){
		$model=$this->loadModel();

		if(isset($_POST['AdvertisingCampaign'])){
			$model->attributes=$_POST['AdvertisingCampaign'];
//			if($model->payment_date > $model->end_time){
//				$model->end_time = $model->payment_date + ($model->choose_scope * 86400 * 7);
//				$model->end_time = $model->payment_date + (86400 * 7);
//			}
			if(empty($model->end_time)){
				$model->end_time=mktime(0, 0, 0, 3, 0, 2040);
			}elseif(!is_numeric($model->end_time)){
				$args=explode('.', $model->end_time);
				$model->end_time=mktime(0, 1, 0, $args[1], $args[0], $args[2]);
			}
			if(!is_numeric($model->start_time)){
				$args=explode('.', $model->start_time);
				$model->start_time=mktime(0, 1, 0, $args[1], $args[0], $args[2]);
			}


			if($model->save()){
				$this->redirect(array('admin'));
			}else{
				throw new CHttpException(404, $model->getErrors());
			}
		}

		$this->render('update', array('model'=>$model));
	}

	public function actionDelete(){
		if(Yii::app()->request->isPostRequest){
			$this->loadModel()->delete();

			if(!isset($_GET['ajax'])){
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

	public function actionIndex(){
		$dataProvider=new CActiveDataProvider('AdvertisingCampaign');

		$this->render('index', array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionCheck(){
		$campaigns=array();
		foreach(UserVisiting::model()->findAll() as $visit){
			$id=$visit->advertising_campaign_id;
			if(!isset($campaigns[$visit->advertising_campaign_id]))
				$campaigns[$id]=array();

			if($visit->count_viewed > $visit->campaign->advertisingType->dimension && $visit->campaign->advertisingType->type == 'SCOPE'){
				$campaigns[$id]['company']=$visit->campaign->company->name;
				$campaigns[$id]['campaign']=$visit->campaign->getImage(true);
				$campaigns[$id]['views']=$visit->count_viewed;
				$campaigns[$id]['clicks']=$visit->count_clicked;
			}
		}

		$this->render('check', array('campaigns'=>$campaigns));
	}

	public function actionAdmin(){
		$model=new AdvertisingCampaign('search');
		$model->unsetAttributes();

		if(isset($_GET['AdvertisingCampaign']))
			$model->attributes=$_GET['AdvertisingCampaign'];

		$this->render('admin', array(
			'model'=>$model,
		));
	}

	protected function performAjaxValidation($model, $form){
		if(isset($_POST['ajax']) && $_POST['ajax'] == $form){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
