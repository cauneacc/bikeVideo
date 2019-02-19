<?php

class TagsController extends Controller {


	public function actionIndex() {
		if (isset($_GET['id']) == true or isset($_GET['slug'])) {
			if (is_numeric($_GET['id']) == true) {//use the id of the tag
				$videosPerPage = 20;
				$sql = 'SELECT name
					FROM {{video_tags}}
					WHERE tag_id = :tagId';
				$tag = VideoTags::model()->findBySql($sql, array(':tagId' => $_GET['id']));
				if ($tag) {
					header('HTTP/1.1 301 Moved Permanently');
					header('Location: ' . $this->createAbsoluteUrl('/video/tags/index', array('slug' => $tag->name)));
					exit;
				}
			} elseif (empty($_GET['slug']) == false) {//use the slug of the tag
				$slug = trim(urldecode($_GET['slug']));
				$videosPerPage = 20;
				$sql = 'SELECT count(*)
					FROM {{video}} AS v
					INNER JOIN {{video_tags_lookup}} AS l
					ON v.video_id=l.video_id
					inner join {{video_tags}} as t
					on l.tag_id=t.tag_id
					WHERE v.status=1
					AND t.name = :slug';
				$count = Video::model()->countBySql($sql, array(':slug' => $slug));
				if ($count > 0) {
					$pages = new CPagination($count);
					// results per page
					$pages->pageSize = $videosPerPage;
					$orderString = Yii::app()->controller->module->chooseOrdering($_GET['order']);
					$sql = 'SELECT v.*
					FROM {{video}} AS v
					INNER JOIN {{video_tags_lookup}} AS l
					ON v.video_id=l.video_id
					inner join {{video_tags}} as t
					on l.tag_id=t.tag_id
					WHERE v.status=1
					AND t.name = :slug
					ORDER BY ' . $orderString . '
					LIMIT ' . $pages->getLimit() . '
					OFFSET ' . $pages->getOffset();
					$videos = Video::model()->cache(Yii::app()->params['longCacheTime'])->findAllBySql($sql, array(':slug' => $slug));
					$countVideos = count($videos);
					if ($countVideos < $videosPerPage) {
						$videosIds = '';
						for ($i = 0; $i < $countVideos; $i++) {
							$videoIds = $videoIds . ',' . $videos[$i]->video_id;
						}
						if (strlen($videoIds) > 0) {
							$videoIds = 'and v.video_id not in (' . substr($videoIds, 1) . ')';
						}
						$sql = 'SELECT v.* 
								FROM {{video}} as v 
								JOIN (SELECT FLOOR(MAX(video_id)*RAND()) AS video_id FROM {{video}}) AS x 
								ON v.video_id >= x.video_id 
								where v.status=1 ' . $videoIds . '
								LIMIT ' . ($videosPerPage - $countVideos);
						$videos2 = Video::model()->cache(Yii::app()->params['smallCacheTime'])->findAllBySql($sql);
						$videos = array_merge($videos, $videos2);
					}
//				$categories=Yii::app()->controller->module->getCategories();
					$categories = VideoCategories::getCategoriesForDisplay();
					if (isset($_GET['order'])) {
						$pages->params = array('order' => $_GET['order']);
					}
				} else {
					$pages = new CPagination($count);
					// results per page
					$pages->pageSize = $videosPerPage;
					$orderString = Yii::app()->controller->module->chooseOrdering($_GET['order']);
					$sql = 'SELECT v.*
					FROM {{video}} AS v
					WHERE v.status=1
					ORDER BY rand()
					LIMIT 20';
					$videos = Video::model()->cache(Yii::app()->params['smallCacheTime'])->findAllBySql($sql);
					$categories = VideoCategories::getCategoriesForDisplay();
					if (isset($_GET['order'])) {
						$pages->params = array('order' => $_GET['order']);
					}
				}
				$sql = 'SELECT l.*
				FROM {{video_tags}} AS t
				INNER JOIN {{tag_links}} AS l
				ON (t.tag_id=l.tag_id)
				WHERE t.name = :slug
				order by rand() limit 10';
				$tagLinks = TagLinks::model()->cache(Yii::app()->params['longCacheTime'])->findAllBySql($sql, array(':slug' => $slug));

				//meta tags
				Yii::import('application.modules.video.libraries.BMetaInformation');
				$metaInformation = new BMetaInformation();
				$metaInformation->setMetaInformation($this, BMetaInformation::PAGE_TYPE_TAG, $slug, Yii::app()->controller->module->getVideoTagsForMetaTags($videos), ucfirst($slug));
				//end meta tags

				$this->render('/default/browse', array('videos' => $videos,
					'pages' => $pages, 'categoriesWidgetData' => $categories,
					'orderingBaseUrl' => 'video/tags/index?slug=' . $slug,
					'tagLinks' => $tagLinks,
					'browseTitle' => $this->pageTitle));
			} else {
				$this->redirect(Yii::app()->createAbsoluteUrl('/'));
			}
		} else {
			$this->redirect(Yii::app()->createAbsoluteUrl('/'));
		}
	}

}

?>
