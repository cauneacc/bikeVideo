<?php

class CategoriesController extends Controller {

//public function filters()
//{
//    return array(
//        array(
//            'COutputCache',
//            'duration'=>100,
//            'varyByParam'=>array('slug'),
//        ),
//    );
//}

	var $relNext;
	var $relPrev;
	var $canonicalLink;
	
	public function actionIndex() {
		if (isset($_GET['slug'])) {
			$_GET['page']=(int)$_GET['page'];
			$categoriesMapping = $this->getCategoriesMapping();
			$cleanSlug = trim(strtolower($_GET['slug']));
			if (isset($categoriesMapping[$cleanSlug])) {
				$categoryId=$categoriesMapping[$cleanSlug]['cat_id'];
				$category = VideoCategories::model()->cache(Yii::app()->params['longCacheTime'])->find('cat_id=:id', array(':id' => $categoryId));
				if ($category) {
					$categories = VideoCategories::getCategoriesForDisplay();
					$sql = 'SELECT count(*)
					FROM {{video}} AS v
					INNER JOIN {{video_category}} AS c
					ON v.video_id=c.video_id
					WHERE c.cat_id=:catId
					AND v.status=1';
					$count = Video::model()->cache(Yii::app()->params['mediumCacheTime'])->countBySql($sql, array(':catId' => $categoryId));
					$pages = new CPagination($count);
					$pages->pageSize = Yii::app()->params['videosPerPage'];
					if (isset($_GET['order'])) {
						switch ($_GET['order']) {
							case 'duration':
								$orderString = 'v.duration desc';
								break;
							case 'rating':
								$orderString = 'v.rating desc';
								break;
							case 'popular':
								$orderString = 'v.total_views desc';
								break;

							default:
								$orderString = 'v.video_id desc';
								break;
						}
					} else {
						$orderString = 'v.video_id desc';
					}
					$sql = 'SELECT *
					FROM {{video}} AS v
					INNER JOIN {{video_category}} AS c
					ON v.video_id=c.video_id
					WHERE c.cat_id=:catId
					AND status=1';
					$sql = $sql . ' ORDER BY ' . $orderString . ' LIMIT ' . $pages->getLimit() . ' OFFSET ' . $pages->getOffset();
					$videos = Video::model()->cache(Yii::app()->params['mediumCacheTime'])->findAllBySql($sql, array(':catId' => $categoryId));
					if (isset($_GET['order'])) {
						$pages->params = array('order' => $_GET['order']);
					}
					Yii::import('application.modules.cms2.models.*');
					$articles =Cms2Articles::model()->with('Cms2Images')->findAll('category_id=:categoryId',array(':categoryId'=>$category->cat_id));
					//meta tags
					Yii::import('application.modules.video.libraries.BMetaInformation');
					$metaInformation = new BMetaInformation();
					$metaInformation->setMetaInformation($this, BMetaInformation::PAGE_TYPE_VIDEO_CATEGORY, ucfirst($categoriesMapping[$cleanSlug]['name']), Yii::app()->controller->module->getVideoTagsForMetaTags($videos), ucfirst($categoriesMapping[$cleanSlug]['description']));
					//end meta tags
					//canonical link, rel next, rel prev
					if($_SERVER['REQUEST_URI']!=str_replace('?page=0', '',Yii::app()->createUrl($this->route, array('slug'=>$_GET['slug'],'page'=>$_GET['page'])))){
						$this->canonicalLink=Yii::app()->createUrl($this->route, array('slug'=>$_GET['slug'],'page'=>$_GET['page']));
					}
					if($pages->pageCount>($pages->currentPage+1)){
						$this->relNext=trim(Yii::app()->params['rootUrl'],'/').$pages->createPageUrl($this, $pages->currentPage+1);
					}
					if($pages->currentPage>0){
						$this->relPrev=trim(Yii::app()->params['rootUrl'],'/').$pages->createPageUrl($this, $pages->currentPage-1);
					}
					//end canonical link, rel next, rel prev
					//add order and page number in page title
					if ($pages->currentPage > 0) {
						$pageTitleSufix = $pageTitleSufix . ' - ' . Yii::t('app', 'page {pageNumber}', array('{pageNumber}' => $pages->currentPage + 1));
					}
					$this->pageTitle = $this->pageTitle . ' ' . $pageTitleSufix;

					$this->render('/default/browse', array('videos' => $videos,
						'pages' => $pages, 'categoriesWidgetData' => $categories,
						'articles'=>$articles,'category'=>$category,
						'orderingBaseUrl' => 'video/categories/index?id=' . (int) $categoryId . '&name=' . $_GET['name'],
						'browseTitle' => $this->pageTitle));
				} else {
					throw new CHttpException(404);
				}
			} else {
				throw new CHttpException(404);
			}
		} else {
			throw new CHttpException(404);
		}
	}

	protected function getCategoriesMapping() {
		$categoriesMapping = Yii::app()->cache->get('categoriesController.categoriesSlugIdMapping');
		if (empty($categoriesMapping)) {
			$dataReader = Yii::app()->db->createCommand('select cat_id, slug, name, description from {{video_categories}} where status=\'1\'')->query();
			$categoriesMapping = array();
			while (($row = $dataReader->read()) !== false) {
				$categoriesMapping[$row['slug']] = $row;
			}
			Yii::app()->cache->set('categoriesController.categoriesSlugIdMapping', $categoriesMapping);
		}
		return $categoriesMapping;
	}

	public function actionList() {
		$categories = VideoCategories::model()->findAll('status=:status AND parent_cat_id=0', array(':status' => VideoCategories::ENABLED));
		//meta tags
		Yii::import('application.modules.video.libraries.BMetaInformation');
		$metaInformation = new BMetaInformation();
		$metaInformation->setDefaultMetaInformation($this);
		//end meta tags

		$this->render('list', array('categories' => $categories));
	}

}