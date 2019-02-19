<?php

class Position extends CActiveRecord{

	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	public function tableName(){
		return '{{position}}';
	}

	public function rules(){
		return array(
			array('title', 'required'),
			array('title', 'unique'),
			array('title', 'length', 'max'=>255),
			array('title', 'safe', 'on'=>'search'),
		);
	}

	public function relations(){
		return array(
			'template'=>array(self::HAS_MANY, 'AdvertisingTemplate', 'position_id')
		);
	}

	public function attributeLabels(){
		return array(
			'title'=>Yii::t('app', 'Title'),
		);
	}

	public function search(){
		$criteria=new CDbCriteria;
		$criteria->compare('title', $this->title, true);
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	public function __toString(){
		return $this->title;
	}

}
