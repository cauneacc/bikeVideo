<?php
class AdvertisingSponsor extends CActiveRecord{

	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	public function tableName(){
		return '{{advertising_sponsor}}';
	}

	public function beforeValidate(){
		return parent::beforeValidate();
	}

	public function relations(){
		return array('campaigns'=>array(self::HAS_MANY, 'AdvertisingCampaign', 'sponsor_id'));
	}

	public function behaviors(){
		return array(
			'CSerializeBehavior'=>array(
				'class'=>'application.modules.advertisement.components.CSerializeBehavior',
				'serialAttributes'=>array()));
	}

	public function rules(){
		return array(
			array('name', 'required'),
			array('priority', 'required'),
			array('percent', 'required'),
			array('name', 'length', 'max'=>255),
			array('id, name, priority, percent', 'safe'),
		);
	}

	protected function beforeDelete(){
		parent::beforeDelete();
		$criteria=new CDbCriteria();
		$criteria->compare('sponsor_id', $this->getPrimaryKey());
		return AdvertisingCampaign::model()->deleteAll($criteria);
	}
/**
 * Deleting the sponsors procents from cache
 *
 * see protected/modules/advertisement/models/Ad.php
 */
	protected function afterSave(){
		parent::afterSave();
		
		Yii::app()->cache->delete('sponsorsAdDisplayPercent');
	}

	public function __toString(){
		return $this->name;
	}
}
?>
