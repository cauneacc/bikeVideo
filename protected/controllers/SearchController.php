<?php
/**
 * Searchcontroller
 **/
class SearchController extends CController
{
	public function actionSearch($search = null, $searchmethod) {
		if(!$search)
			$this->redirect(array('//site/index'));
	
		if($searchmethod == 'Images') 
			$this->redirect(array('//photo/photo/index', 'title' => $search));

		if($searchmethod == 'Blog') 
			$this->redirect(array('//blog/posts/index', 'title' => $search));

	}
}
