<?php

/**
 * This is the model base class for the table "banner_type".
 *
 * Columns in table "banner_type" available as properties of the model:
 * @property integer $id
 * @property string $title
 * @property string $size
 *
 * There are no model relations.
 */
abstract class BaseBannerType extends CActiveRecord{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{banner_type}}';
	}

	public function rules()
	{
		return array(
			array('title, size', 'required'),
			array('title, size', 'length', 'max'=>255),
			array('id, title, size', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
				'advertisingType' => array(self::HAS_MANY, 'AdvertisingType','banner_type')
				);
	}

	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app', 'ID'),
			'title' => Yii::t('app', 'Title'),
			'size' => Yii::t('app', 'Size'),
		);
	}


	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('size', $this->size, true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
