<?php

abstract class BaseAdvertisingCampaign extends CActiveRecord{

	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	public function tableName(){
		return '{{advertising_campaign}}';
	}

	public function rules(){
		return array(
			array('category, mode, createtime, updatetime, start_time, end_time, status, title', 'required'),
			array('title', 'unique'),
			array('title, dimension, countries, positions,  tags', 'length', 'max'=>255),
			array('priority', 'in', 'range'=>array(1, 2, 3, 4, 5)),
			array('price', 'numerical'),
			array('end_time, url_link', 'default', 'setOnEmpty'=>true, 'value'=>null),
			array('url_link', 'url', 'on'=>'image'),
			array('category', 'length', 'max'=>10),
			array('createtime, updatetime, end_time, status, category, sponsor_id', 'numerical', 'integerOnly'=>true),
			array('url_picture, url_link', 'length', 'max'=>255),
			array('createtime, updatetime, start_time, end_time, id, status, url_picture, url_link, payment_date, category, type, script, mode, text', 'safe'),
			array('url_picture', 'EPhotoValidator', 'on'=>'banner_type1', 'width'=>120, 'height'=>90),
			array('url_picture', 'EPhotoValidator', 'on'=>'banner_type2', 'width'=>160, 'height'=>600),
			array('url_picture', 'EPhotoValidator', 'on'=>'banner_type3', 'width'=>728, 'height'=>90));
	}

	public function relations(){
		return array(
			'category'=>array(self::BELONGS_TO, 'AdvertisingCategory', 'category'),
			'advertisingSponsor'=>array(self::BELONGS_TO, 'AdvertisingSponsor', 'sponsor_id'),
			'paymentType'=>array(self::BELONGS_TO, 'Payment', 'payment_type'),
			'visits'=>array(self::HAS_MANY, 'UserVisit', 'advertising_campaign_id'),
			'user_visits'=>array(self::MANY_MANY, 'Users', 'user_visiting(advertising_campaign_id, users_id)'),
		);
	}

	public function attributeLabels(){
		return array(
			'createtime'=>Yii::t('app', 'Create time'),
			'updatetime'=>Yii::t('app', 'Update time'),
			'start_time'=>Yii::t('app', 'Start of campaign'),
			'end_time'=>Yii::t('app', 'End or campaign'),
			'id'=>Yii::t('app', 'ID'),
			'status'=>Yii::t('app', 'Status'),
			'url_picture'=>Yii::t('app', 'Url picture'),
			'url_link'=>Yii::t('app', 'Url link'),
			'accept_agb'=>Yii::t('app', 'AGB accepted'),
			'payment_date'=>Yii::t('app', 'Payment date'),
			'payment_type'=>Yii::t('app', 'Payment type'),
			'advertising_type'=>Yii::t('app', 'Advertising type'),
			'sponsor_id'=>Yii::t('app', 'Sponsor'),
		);
	}

	public function search(){
		$criteria=new CDbCriteria;
		$criteria->with='advertisingSponsor';
		$criteria->compare('createtime', $this->createtime);
		$criteria->compare('updatetime', $this->updatetime);
		$criteria->compare('start_time', $this->start_time);
		$criteria->compare('end_time', $this->end_time);
		$criteria->compare('id', $this->id);
		$criteria->compare('status', $this->status);
		$criteria->compare('sponsor_id', $this->sponsor_id);
		$criteria->compare('countries', $this->countries);
		$criteria->compare('positions', $this->positions);
		$criteria->compare('tags', $this->tags);
		$criteria->compare('priority', $this->priority);
		$criteria->compare('price', $this->price);
		$criteria->compare('mode', $this->mode);
		$criteria->compare('url_picture', $this->url_picture, true);
		$criteria->compare('url_link', $this->url_link, true);
		$criteria->compare('payment_date', $this->payment_date);
		$criteria->compare('payment_type', $this->payment_type, true);
		$criteria->compare('category', $this->category);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	public function behaviors(){
		return array(
			'CSerializeBehavior'=>array(
				'class'=>'application.modules.advertisement.components.CSerializeBehavior',
				'serialAttributes'=>array('text'),
			)
		);
	}

}
