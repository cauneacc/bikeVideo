<?php
class SitemapController extends Controller{

	public function actionMakeSitemap(){
		Yii::import('application.components.BSitemap');
		$sitemap=new BSitemap();
		if($sitemap->createSitemap()){
			echo 'success';
		}else{
			echo 'error';
		}
		exit;

	}
}
?>
