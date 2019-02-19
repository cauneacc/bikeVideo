<?php

Yii::import('application.modules.advertisement.models.*');

class AdvertisementController extends Controller {

	public function actionCreateUpdateCampaigns() {
		$data = @unserialize($_POST['data']);
		if ($data) {
			if (is_array($data)) {
				foreach ($data as $campaign) {
					AdvertisingCampaign::model()->deleteByPk($campaign['id']);
					$model = new AdvertisingCampaign();
					$model->attributes = $campaign;
					$model->id=$campaign['id'];
					if ($model->save() == false) {
						echo serialize($model->getErrors());
					}
				}
				echo 'success';
			}
		}
	}

	public function actionCreateUpdatePositions() {
		$data = @unserialize($_POST['data']);
		if ($data) {
			if (is_array($data)) {
				$errors=array();
				foreach ($data as $position) {
					AdvertisingCampaign::model()->deleteByPk($position['id']);
				}
				foreach ($data as $position) {
					$model = new Position();
					$model->title = $position['title'];
					$model->id=$position['id'];
					if ($model->save() == false) {
						Yii::log('createupdateposition '.var_export($model->getErrors(),true), 'error', __CLASS__);
						Yii::log('Errors while trying to insert in the database advertising positons'.var_export($model->getErrors(),true), 'error', __CLASS__);
						$errors[]=$model->getErrors();
					} 
				}
				if(count($errors)>0){
					echo serialize($errors);
				}else{
					echo 'success';
				}
			}
		}
	}

	public function actionCreateOtherAdvertisingItems() {
		$data = @unserialize($_POST['data']);
		if ($data) {
			if (is_array($data)) {
				$errors=array();
				foreach ($data as $item) {
					if (class_exists($item['class'])) {
						$model = new $item['class']();
						$r = $model->deleteByPk($item['id']);
						$model = new $item['class']();
						unset($item['class']);
						$model->attributes = $item;
						$model->id = $item['id'];
						if ($model->save() == false) {
							Yii::log('Errors while trying to insert in the database other advertising items '.var_export($model->getErrors(),true), 'error', __CLASS__);
							$errors[]=$model->getErrors();
						} 
					} else {
						$errors[]=array('The class "' . $item['class'] . '" does not exist.');
					}
				}
				if(count($errors)>0){
					echo serialize($errors);
				}else{
					echo 'success';
				}

			}
		}
	}

}
