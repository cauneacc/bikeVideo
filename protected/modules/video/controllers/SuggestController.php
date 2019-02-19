<?php

class SuggestController extends Controller {

	public function actionIndex() {
		if (isset($_GET['slug']) == true) {
			$blacklistedKeyword = KeywordsBlacklist::model()->find('word=:word', array(':word' => $_GET['slug']));
			if ($blacklistedKeyword) {
				header('HTTP/1.0 404 Not Found');
				exit;
			} else {

				$seoKeywords = SeoKeywordsPage::model()->find('word=:word and status=1', array(':word' => $_GET['slug']));
				if ($seoKeywords) {
					$videoTag = VideoTags::model()->find('name=:name ', array(':name' => $_GET['slug']));
					if ($videoTag) {
						// results per page
						$sql = 'SELECT v.*
					FROM {{video}} AS v
					INNER JOIN {{video_tags_lookup}} AS l
					ON v.video_id=l.video_id
					WHERE v.status=1
					AND l.tag_id=:tagId
					ORDER BY rand()
					LIMIT 10';
						$videos = Video::model()->cache(Yii::app()->params['longCacheTime'])->findAllBySql($sql, array(':tagId' => $videoTag->tag_id));
					} else {
						$sql = 'SELECT v.*
							FROM {{video}} AS v
							WHERE v.status=1
							ORDER BY rand()
							LIMIT 10';
						$videos = Video::model()->cache(Yii::app()->params['longCacheTime'])->findAllBySql($sql);
					}
				} else {
					header('HTTP/1.0 404 Not Found');
					exit;
				}
				//meta tags
				Yii::import('application.modules.video.libraries.BMetaInformation');
				$metaInformation = new BMetaInformation();
				$metaInformation->setMetaInformation($this, BMetaInformation::PAGE_TYPE_TAG, $_GET['slug'], Yii::app()->controller->module->getVideoTagsForMetaTags($videos), ucfirst($_GET['slug']));
				//end meta tags
				$categories = VideoCategories::getCategoriesForDisplay();
				$this->render('/suggest/index', array('videos' => $videos,
					'categoriesWidgetData' => $categories,
					'browseTitle' => $this->pageTitle));
			}
		} else {
			header('HTTP/1.0 404 Not Found');
			exit;
		}
	}
	
	//display last 500 seo keywords
	public function actionKeywords(){
		$seoKeywords = SeoKeywordsPage::model()->cache(Yii::app()->params['longCacheTime'])->findAll('status=1 order by id desc limit 500');
		$this->render('/suggest/keywords', array('seoKeywords' => $seoKeywords));
	}

}

?>
