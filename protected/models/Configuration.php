<?php

class Configuration extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	public function behaviors() {
		return array(
				'CSerializeBehavior' => array(
					'class' => 'application.components.CSerializeBehavior',
					'serialAttributes' => array(
						'value')));
	}

	public function tableName()
	{
		return '{{configuration}}';
	}

	public function rules()
	{
		return array(
			array('section, value', 'required'),
			array('section', 'length', 'max'=>255),
			array('id, section, value', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array();
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'section' => 'Section',
			'value' => 'Value',
		);
	}

//	public function save(){
//		$value=$this->value;
//		$section=$this->section;
//		$r=parent::save();
//		if($r==true){
//			Yii::import('ext.configuration.BConfigurationHelper');
//			$configHelper=new BConfigurationHelper();
//			return $configHelper->saveConfigurationToFile($value,$section);
//		}
//	}

	public static function saveConfigurationToFile(){
		$command=Yii::app()->db->createCommand('select value from {{configuration}} where section=\'unifiedConfiguration\'');
		$configuration=$command->queryAll();
		if($configuration){
			$aux=unserialize($configuration[0]['value']);
			if($aux===false){
				return false;
			}else{
				return file_put_contents(Yii::getPathOfAlias('application.config.custom.unifiedConfiguration').'.php','<?php return '.var_export($aux,true).'?>');
			}
		}else{
			return false;
		}
	}
}
