<?php

class AdvertisingCategory extends CActiveRecord{

	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	public function tableName(){
		return '{{advertising_category}}';
	}

	public function beforeValidate(){
		return parent::beforeValidate();
	}

	public function rules(){
		return array(
			array('title', 'required'),
			array('description', 'default', 'setOnEmpty'=>true, 'value'=>null),
			array('title', 'length', 'max'=>255),
			array('id, title, description', 'safe'),
		);
	}

	public function init(){
		return parent::init();
	}

	public function __toString(){
		return (string)$this->title;
	}

	public function getAdvertisements($target_category = 0, $target_modul = false){
		$criteria=new CDbCriteria;
		$criteria->addCondition('status = 1');
		$criteria->addCondition('payment_date != 0');
		$criteria->addCondition('advertising_type = '.$this->id);

		$criteria->addCondition('target_category = '.$target_category);
		if($target_modul)
			$criteria->addCondition('target_modul = \''.$target_modul.'\'');

		$criteria->addCondition('target_category = 0', 'or');

		if($this->option == 'PERIOD'){
			$criteria->addCondition('end_time > '.time());
			$criteria->addCondition('start_time < '.time());
			//		$criteria->addCondition('payment_date < '. time());
		}

		return AdvertisingCampaign::model()->findAll($criteria);
	}

	public function attributeLabels(){
		return array(
			'id'=>Yii::t('app', 'ID'),
			'title'=>Yii::t('app', 'Title'),
			'description'=>Yii::t('app', 'Description'),
		);
	}

	public function behaviors(){
		return array(
			'CSerializeBehavior'=>array(
				'class'=>'application.modules.advertisement.components.CSerializeBehavior',
				'serialAttributes'=>array()));
	}

	public function search(){
		$criteria=new CDbCriteria;
		$criteria->with=array('campaigns');
		$criteria->compare('{{advertising_category}}.id', $this->id);
		$criteria->compare('{{advertising_category}}.title', $this->title, true);
		$criteria->compare('{{advertising_category}}.description', $this->description, true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	public function relations(){
		return array('campaigns'=>array(self::HAS_MANY, 'AdvertisingCampaign', 'category'));
	}

	protected function beforeDelete(){
		$criteria=new CDbCriteria();
		$criteria->compare('category', $this->getPrimaryKey());
		return AdvertisingCampaign::model()->deleteAll($criteria);
	}


}
