<?php

abstract class BaseAdvertising extends CActiveRecord{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'advertising';
	}

	public function rules()
	{
		return array(
			array('url_picture, url_link', 'required'),
			array('id, advertising_type, company_id', 'numerical', 'integerOnly'=>true),
			array('url_link', 'url'),
			array('url_picture, url_link', 'length', 'max'=>255),
			array('id, url_picture, url_link, advertising_type', 'safe'),
		);
	}

	public function relations()
	{
		return array(
			'type' => array(self::BELONGS_TO, 'AdvertisingType', 'advertising_type'),
			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
			'campaigns' => array(self::HAS_MANY, 'AdvertisingCampaign', 'advertising_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app', 'ID'),
			'url_picture' => Yii::t('app', 'Bild'),
			'url_link' => Yii::t('app', 'Url Link'),
			'advertising_type' => Yii::t('app', 'Werbetyp'),
			'company_id' => 'Firma',
		);
	}


	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('url_picture', $this->url_picture, true);
		$criteria->compare('url_link', $this->url_link, true);
		$criteria->compare('advertising_type', $this->advertising_type);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
