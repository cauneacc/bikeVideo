<?php

class AdvertisingCampaign extends BaseAdvertisingCampaign{

	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	public function getImage($preview = false){
		$url=Yii::app()->baseUrl;
		if($preview)
			return CHtml::image($url.'/images/banner/'.$this->url_picture, 'Preview', array('width'=>'150', 'height'=>150));
		else
			return CHtml::image($url.'/images/banner/'.$this->url_picture, 'Preview');
	}

	public function activate(){
		$this->status=1;
		$this->payment_date=time();

		$this->save();
	}

	public function init(){
		return parent::init();
	}

	public function __toString(){
		return (string)$this->target_url;
	}

	public function beforeValidate(){
		if(!is_numeric($this->start_time)){
			$time=explode('/', $this->start_time);
			$this->start_time=mktime(0, 0, 0, $time[1], $time[0], $time[2]);
		}
		if(!is_numeric($this->end_time)){
			$time=explode('/', $this->end_time);
			$this->end_time=mktime(0, 0, 0, $time[1], $time[0], $time[2]);
		}

		$countries=explode(',', $this->countries);
		foreach($countries as $k=>$v)
			$countries[$k]=trim($v);

		if(count($countries) !== count(array_unique($countries)))
			$this->addError('countries', 'Please choose each country only once');

		$tags=explode(',', $this->tags);
		foreach($tags as $k=>$v)
			$tags[$k]=trim($v);

		if(count($tags) !== count(array_unique($tags)))
			$this->addError('tags', 'Please choose each tag only once');

		if(is_null($this->status))
			$this->status=0;

		if($this->isNewRecord)
			$this->createtime=time();
		$this->updatetime=time();

		return parent::beforeValidate();
	}


	public function getPositions(){
		$sql="select positions from ".AdvertisingCampaign::tableName()." group by positions";
		$result=Yii::app()->db->createCommand($sql)->queryAll();

		$positions=array();
		foreach($result as $record)
			if($record['position'] != null)
				$positions[]=$record['position'];

		$sql="select title from ".Position::tableName();
		$result=Yii::app()->db->createCommand($sql)->queryAll();
		foreach($result as $record){
			if($record['title'] != null)
				$positions[]=$record['title'];
		}
		return $positions;
	}

	public function rules(){
		return array_merge(
			/* array('column1, column2', 'rule'), */
			parent::rules()
		);
	}

	public function drawTextAd(){
		if(!$this->mode == 'text')
			return false;

		printf('%s <br />%s <br />%s<br />%s<br />%s</br>%s</br>',
			$this->text['title'],
			$this->text['url_input'],
			$this->text['line1'],
			$this->text['line2'],
			$this->text['line3'],
			$this->text['visibleUrl']);
	}

	public function tableName(){
		return '{{advertising_campaign}}';
	}

	public function createNew($data){
		$this->attributes=$data;
		$this->url_picture=CUploadedFile::getInstance($this, 'url_picture');
		$this->validate();
		if(!$this->hasErrors() && $this->save()){
			if(is_object($this->url_picture)){
				$this->url_picture->saveAs(Yii::app()->basePath.'/..'.Ad::module()->imagePath.$this->url_picture);
				return true;
			}
		}
		return false;
	}

	public function  beforeSave(){
		parent::beforeSave();
		if(empty($this->payment_date)){
			$this->payment_date='0';
		}
		if(empty($this->price)){
			$this->price='0';
		}

		return true;
	}
}
