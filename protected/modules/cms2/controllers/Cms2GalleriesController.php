<?php
class Cms2GalleriesController extends Controller{
	public $layout='//layouts/frontend';
	
	public function actionView($id){
/*
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.lightbox-0.4.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.4.css" media="screen" />
*/
		$assetsUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.cms2.assets'));
		$cs = Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery');
		$cs->registerScriptFile($assetsUrl.'/jquery-lightbox-0.5/js/jquery.lightbox-0.5.pack.js', CClientScript::POS_HEAD);
		$cs->registerCssFile($assetsUrl.'/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css');
		
		$model=Cms2Galleries::model()->with('cms2Images')->findByPk($id);
		$this->render('view', array(
			'model'=>$model,
		));
	}

}
?>
