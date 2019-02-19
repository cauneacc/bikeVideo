<?php

class Cms2ArticlesController extends Controller {

    public $layout = 'nothing';

    public function actionView() {
        $model = Cms2Articles::model()->with('Cms2Images')->find('t.slug=:slug',array(':slug'=>$_GET['slug']));
		if($model->gallery_id){
			$gallery=Cms2Galleries::model()->with('cms2Images')->findByPk($model->gallery_id);
		}else{
			$gallery=null;
		}
        $this->render('view', array(
            'model' => $model,
            'gallery' => $gallery,
        ));
        
        
    }

}

?>
