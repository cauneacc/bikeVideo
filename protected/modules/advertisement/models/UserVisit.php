<?php

class UserVisit extends CActiveRecord 
{



	public function __toString() {
		return (string) $this->user_id;

	}
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{user_visit}}';
	}

	public function rules()
	{
		return array(
				array('user_id, advertising_campaign_id, count_clicked, count_viewed', 'required'),
				array('user_id, advertising_campaign_id, count_clicked, count_viewed', 'numerical', 'integerOnly'=>true),
				array('user_id, advertising_campaign_id, ip_addr, country, user_agent, visittime', 'safe'),
				);
	}

	public function relations()
	{
		return array(
				'campaign' => array(self::BELONGS_TO, 'AdvertisingCampaign', 'advertising_campaign_id'),
				'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
				);
	}

	public function attributeLabels()
	{
		return array(
				'user_id' => Yii::t('app', 'Users'),
				'advertising_campaign_id' => Yii::t('app', 'Advertising Campaign'),
				'count_clicked' => Yii::t('app', 'Count Clicked'),
				'count_viewed' => Yii::t('app', 'Count Viewed'),
				);
	}


	public function search()
	{
		$criteria=new CDbCriteria;

var_dump($this->attributes);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('advertising_campaign_id', $this->advertising_campaign_id);
		$criteria->compare('ip_addr', $this->ip_addr);
		$criteria->compare('country', $this->country);
		$criteria->compare('user_agent', $this->user_agent);
		$criteria->compare('visittime', $this->visittime);

		return new CActiveDataProvider(get_class($this), array(
					'criteria'=>$criteria,
					));
	}


}
