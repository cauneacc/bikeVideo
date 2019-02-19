<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	public $assetsJsUrl;
	public $assetsCssUrl;

	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();


	public function init(){
		
		 if($this->module->id!=='admin' and $this->module->id!=='api'){
			 
//			 Yii::app()->clientScript->registerScript('site_url','site_url=\''.Yii::app()->createAbsoluteUrl('/').'/\'',  CClientScript::POS_HEAD);
//			Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/style.css');
		 }
	}
	
	public function afterAction($action){
		parent::afterAction($action);
		if($action->id!='error'){
			SeoKeywordsPage::saveGoogleKeyword();			
		}
	}
	
//	public function getCanonicalLink(){
//		if(substr(Yii::app()->params['rootUrl'], strlen(Yii::app()->params['rootUrl'])-1)=='/'){
//			$a=substr(Yii::app()->params['rootUrl'],0, strlen(Yii::app()->params['rootUrl'])-1).Yii::app()->createUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id,$_GET);
//		}else{
//			$a=Yii::app()->params['rootUrl'].Yii::app()->createUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id,$_GET);
//		}
//		
//		if($a){
//			echo '<link rel="canonical" href="'.$a.'"/>';
//		}
//	}
	
	
	
}