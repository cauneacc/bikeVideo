<?php

class AdvertisingTemplate extends CActiveRecord{

	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	public function tableName(){
		return '{{advertising_template}}';
	}

	public function attributeLabels(){
		return array(
			'id'=>Yii::t('app', 'Id'),
			'name'=>Yii::t('app', 'Name'),
			'template'=>Yii::t('app', 'Template'),
			'css'=>Yii::t('app', 'Css'),
		);
	}

	public function rules(){
		return array(
			array('name, template, css, position_id', 'required'),
			array('name', 'unique'),
			array('name', 'length', 'max'=>255),
			array('position_id', 'numerical'),
			array('template', 'validateAdTemplate'),
		);
	}

	public function relations(){
		return array(
			'position'=>array(self::HAS_ONE, 'Position', 'id'),
		);
	}


	public function validateAdTemplate($attribute, $params){

//$this->addError('password','Incorrect username or password.');

		if(strpos($this->template, '{title}') === false){
			$this->addError('template', Yii::t('app', 'The template doesn\'t contain the {title} tag.'));
			return false;
		}
//		if(strpos($this->template, '{urlInput}')===false){
//			$this->addError('template',Yii::t('app','The template doesn\'t contain the {urlInput} tag.'));
//			return false;
//		}
		if(strpos($this->template, '{line1}') === false){
			$this->addError('template', Yii::t('app', 'The template doesn\'t contain the {line1} tag.'));
			return false;
		}
		if(strpos($this->template, '{line2}') === false){
			$this->addError('template', Yii::t('app', 'The template doesn\'t contain the {line2} tag.'));
			return false;
		}
		if(strpos($this->template, '{line3}') === false){
			$this->addError('template', Yii::t('app', 'The template doesn\'t contain the {line3} tag.'));
			return false;
		}
		if(strpos($this->template, '{visibleUrl}') === false){
			$this->addError('template', Yii::t('app', 'The template doesn\'t contain the {visibleUrl} tag.'));
			return false;
		}
		return true;
	}

	protected function afterSave(){
		parent::afterSave();
		$templates=self::model()->findAll();
		$adCss='';
		foreach($templates as $template){
//			$a=preg_replace('/\.-?[_a-zA-Z]+[_a-zA-Z0-9-]*\s*\{/e', "'\\0'.sprintf('%u',crc32($template->name))", $template->css);
			$aux=@preg_replace('/\.-?[_a-zA-Z]+[_a-zA-Z0-9-]*\s*\{/e', "changeCssClassName('\\0',$template->name)", $template->css);
			$adCss=$adCss.(string)$aux;
		}
		if(empty($adCss) == false){
			//also used in protected/components/Controller.php around line 37
			$cssFilePath=Yii::getPathOfAlias('application.runtime.vertisment').'.css';
			if(file_put_contents($cssFilePath, $adCss) != false){
				Yii::app()->getAssetManager()->publish($cssFilePath);
			}else{
				Yii::log(Yii::t('app','Could not save the css file "{adCss}" for the ad',array('{adCss}'=>$cssFilePath)),'error','advertisment');
				return false;
			}
		}else{
			Yii::log(Yii::t('app','Could not create the css rule for ads'),'error','advertisment');
		}
	}

	public static function getCacheTemplateForPosition($templateName,$positionTitle){
		Yii::app()->cache->delete('AdvertisingTemplate.tn-'.$templateName.'pt-'.$positionTitle);
		$template=Yii::app()->cache->get('AdvertisingTemplate.tn-'.$templateName.'pt-'.$positionTitle);
		if($template==false){
			$template=self::model()->find('name=:templateName AND position_id=(SELECT id FROM {{position}} WHERE title=:positionTitle)',array(':templateName'=>$templateName,':positionTitle'=>$positionTitle));
			if(empty($template)){
				$template='{title}<br />{line1}<br />{line2}<br />{line3}<br />{visibleUrl}<br />';
				self::saveCacheTemplateForPosition($templateName,$positionTitle,$template);
				return $template;
			}else{
				self::saveCacheTemplateForPosition($templateName,$positionTitle,$template->template);
				return $template->template;
			}
		}else{
			return $template;
		}
	}

	protected static function saveCacheTemplateForPosition($templateName,$positionTitle,$value){
		Yii::app()->cache->set('AdvertisingTemplate.tn-'.$templateName.'pt-'.$positionTitle,$value);
	}
}

function changeCssClassName($a, $name){
	return substr($a, 0, strlen($a) - 1).sprintf('%u', crc32($name)).'{';
}

?>
