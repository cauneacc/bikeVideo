<?php

class DefaultController extends Controller {

//	public function filters() {
//		return array(
//			array(
//				'COutputCache',
//				'duration' => 100,
//				'varyByParam' => array('id'),
//			),
//		);
//	}
	var $relNext;
	var $relPrev;
	var $canonicalLink;

	public function actionIndex() {
		$_GET['page']=(int)$_GET['page'];
		$criteria = new CDbCriteria(array('condition' => 'status=1'));
		$count = Video::model()->count($criteria);
		$pages = new CPagination($count);
		$pages->route = 'default/index';
		if ($_GET['order']) {
			$pages->params = array('order' => $_GET['order']);
		}
		// results per page
		$pages->pageSize = Yii::app()->params['videosPerPage'];
		$orderString = Yii::app()->controller->module->chooseOrdering($_GET['order']);
		$criteria = new CDbCriteria(array('condition' => 'status=1', 'order' => $orderString));
		$pages->applyLimit($criteria);
		$videos = Video::model()->cache(Yii::app()->params['smallCacheTime'])->findAll($criteria);
		$browseTitle = $this->chooseTitleForBrowsePage($_GET['order']);
		//meta tags
		Yii::import('application.modules.video.libraries.BMetaInformation');
		$metaInformation = new BMetaInformation();
		$metaInformation->setMetaInformation($this, BMetaInformation::PAGE_TYPE_DEFAULT, null, null, null);
		//canonical link, rel next, rel prev
		if($_SERVER['REQUEST_URI']!=str_replace('?page=0', '',Yii::app()->createUrl($this->route, array('page'=>$_GET['page'])))){
			$this->canonicalLink=Yii::app()->createAbsoluteUrl($this->route, array('page'=>$_GET['page']));
		}
		if($pages->pageCount>($pages->currentPage+1)){
			$this->relNext=trim(Yii::app()->params['rootUrl'],'/').$pages->createPageUrl($this, $pages->currentPage+1);
		}
		if($pages->currentPage>0){
			$this->relPrev=trim(Yii::app()->params['rootUrl'],'/').$pages->createPageUrl($this, $pages->currentPage-1);
		}
		//end canonical link, rel next, rel prev
		//add order and page number in page title
		$pageTitleSufix = $browseTitle;
		if ($pages->currentPage > 0) {
			$pageTitleSufix = $pageTitleSufix . ' - ' . Yii::t('app', 'page {pageNumber}', array('{pageNumber}' => $pages->currentPage + 1));
		}
		$this->pageTitle = $this->pageTitle . ' ' . $pageTitleSufix;
		$this->render('browse', array('videos' => $videos, 'pages' => $pages,
			'browseTitle' => $browseTitle));
	}

	private function chooseTitleForBrowsePage($order) {
		if (isset($order)) {
			switch ($order) {
				case 'duration':
					return Yii::t('app', 'Longest Videos');
					break;
				case 'rating':
					return Yii::t('app', 'Top rated Videos');
					break;
				case 'popular':
					return Yii::t('app', 'Most Viewed Videos');
					break;
				default:
					return Yii::t('app', 'Most Recent Videos');
					break;
			}
		} else {
			return Yii::t('app', 'Bike Videos');
		}
	}

	public function actionView() {
		if (isset($_GET['id']) == true) {
			if (is_numeric($_GET['id']) == true) {
				$video = Video::model()->findByPk($_GET['id']);
				if ($video) {
					if ($video->status == 1) {
						$video->total_views = $video->total_views + 1;
						$video->save();
						$sql = 'SELECT t.*
							FROM {{video_tags}} AS t
							INNER JOIN {{video_tags_lookup}} AS l
							ON t.tag_id=l.tag_id
							WHERE l.video_id=:videoId';
						$tags = VideoTags::model()->cache(Yii::app()->params['longCacheTime'])->findAllBySql($sql, array(':videoId' => $_GET['id']));
						$sql = 'select c.* from {{video_categories}} as c
							inner join {{video_category}} as l
							on (c.cat_id=l.cat_id)
							where l.video_id=:videoId';
						$videoCategoriesForThisVideo = VideoCategories::model()->findAllBySql($sql, array(':videoId' => $video->video_id));
						$videoCategoriesSql = '';
						foreach ($videoCategoriesForThisVideo as $videoCategory) {
							$videoCategoriesSql = $videoCategoriesSql . ',\'' . mysql_escape_string($videoCategory->cat_id) . '\'';
						}
						if (strlen($videoCategoriesSql) > 1) {
							$videoCategoriesSql = substr($videoCategoriesSql, 1);
							$categoriesInSql = ' AND c.cat_id IN (' . $videoCategoriesSql . ') ';
						} else {
							$categoriesInSql = '';
						}
						if ($tags) {
							$tagsCondition = '';
							$tagsParams = array();
							foreach ($tags as $key => $tag) {
								$tagsCondition = $tagsCondition . ',:tag' . $key;
								$tagsParams[':tag' . $key] = $tag->tag_id;
							}
							$tagsCondition = substr($tagsCondition, 1);
							if ($tagsCondition != '' and count($tagsParams) > 0) {
								$sql = 'SELECT DISTINCT v.*
									FROM {{video}} AS v
									INNER JOIN {{video_tags_lookup}} AS l
									ON v.video_id=l.video_id
									INNER JOIN {{video_category}} AS c
									ON c.video_id=v.video_id
									WHERE l.tag_id in (' . $tagsCondition . ')
									AND v.status=1
									AND v.video_id <> :videoId
									' . $categoriesInSql . '
									LIMIT 10';
								$tagsParams[':videoId'] = $video->video_id;
								$relatedVideos = Video::model()->cache(Yii::app()->params['longCacheTime'])->findAllBySql($sql, $tagsParams);
							}
						} else {
							$sql = 'SELECT *
								FROM {{video}} as v
								INNER JOIN {{video_category}} AS c
								ON c.video_id=v.video_id
								WHERE v.status=1
								AND v.video_id <> :videoId
								' . $categoriesInSql . '
								LIMIT 10';
							$relatedVideos = Video::model()->cache(Yii::app()->params['longCacheTime'])->findAllBySql($sql, array(':videoId' => $video->video_id));
						}

						//meta tags
						$keywords = '';
						foreach ($tags as $tag) {
							$keywords = $keywords . ',' . $tag->name;
						}
						$keywords = substr($keywords, 1);
						Yii::import('application.modules.video.libraries.BMetaInformation');
						$metaInformation = new BMetaInformation();
						$metaInformation->setMetaInformation($this, BMetaInformation::PAGE_TYPE_VIDEO_VIEW, $video->title, $keywords, $video->description);
						//end meta tags

						if ($categoriesInSql) {
							$sql = 'SELECT *
								FROM {{video}} as v
								INNER JOIN {{video_category}} AS c
								ON c.video_id=v.video_id
								WHERE v.status=1
								AND v.video_id <> :videoId
								' . $categoriesInSql . '
								ORDER BY v.video_id desc
								LIMIT 12 ';
							$videosFromTheSameCategory = Video::model()->cache(Yii::app()->params['longCacheTime'])->findAllBySql($sql, array(':videoId' => $video->video_id));
						} else {
							$sql = 'SELECT *
								FROM {{video}} AS v
								WHERE v.video_id NOT IN (SELECT video_id FROM {{video_category}} AS c)
								AND v.status=1
								AND v.video_id <> :videoId
								ORDER BY v.video_id desc
								LIMIT 12 ';
							$videosFromTheSameCategory = Video::model()->cache(Yii::app()->params['longCacheTime'])->findAllBySql($sql, array(':videoId' => $video->video_id));
						}

						$this->render('view', array('video' => $video,
							'relatedVideos' => $relatedVideos,
							'tags' => $tags,
							'videoCategoriesForThisVideo' => $videoCategoriesForThisVideo,
							'videosFromTheSameCategory' => $videosFromTheSameCategory));
					} else {
						$this->redirect(array('/'));
					}
				} else {
					$this->redirect(array('/'));
				}
			}
		}
	}

	protected function makeCodeForEmbed($video) {
		$r = array();
		if (empty($video->embed_code) == true) {
			$fileUrl = Yii::app()->baseUrl . '/videos/' . BVideo::createVideoPartialPath($params['video']->video_id) . '/' . $params['video']->video_id . '.' . $params['video']->ext;
			$embedCode = '<object id="player" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" name="player" width="{embedWidth}" height="{embedHeight}">
		<param name="movie" value="{themeBaseUrl}/swf/player.swf" />
		<param name="allowfullscreen" value="true" />
		<param name="allowscriptaccess" value="always" />
		<param name="flashvars" value="file=' . $fileUrl . '" />
		<embed
			type="application/x-shockwave-flash"
			id="player2"
			name="player2"
			src="{themeBaseUrl}/swf/player.swf"
			width="{embedWidth}"
			height="{embedHeight}"
			allowscriptaccess="always"
			allowfullscreen="true"
			flashvars="file=' . $fileUrl . '"
		/>
	</object>';
			$r['small'] = str_replace(array('{embedWidth}', '{embedHeight}', '{themeBaseUrl}'), array(320, 240, Yii::app()->theme->baseUrl), $embedCode);
			$r['normal'] = str_replace(array('{embedWidth}', '{embedHeight}', '{themeBaseUrl}'), array(Yii::app()->params['videoPlayerWidth'], Yii::app()->params['videoPlayerHeight'], Yii::app()->theme->baseUrl), $embedCode);
		} else {
			if (strpos($video->embed_code, '{embedWidth}') !== false) {
				$r['small'] = str_replace(array('{embedWidth}', '{embedHeight}', '{themeBaseUrl}'), array(320, 240, Yii::app()->theme->baseUrl), $video->embed_code);
				$r['normal'] = str_replace(array('{embedWidth}', '{embedHeight}', '{themeBaseUrl}'), array(Yii::app()->params['videoPlayerWidth'], Yii::app()->params['videoPlayerHeight'], Yii::app()->theme->baseUrl), $video->embed_code);
			} else {
				$r['small'] = $this->resizeVadorEmbedded($video->embed_code, 320, 240);
				$r['normal'] = $this->resizeVadorEmbedded($video->embed_code, Yii::app()->params['videoPlayerWidth'], Yii::app()->params['videoPlayerHeight']);
			}
		}
		return $r;
	}

	public function actionSearch() {
		if (isset($_REQUEST['search'])) {
			Yii::import('application.lib.AGSStringHelper');
			$stringHelper = new AGSStringHelper();
			$search = $stringHelper->prepare_string($_REQUEST['search']);
			if (strlen($search) > 3 and strlen($search) < 15) {
				$criteria = new CDbCriteria(array('condition' => 'status=1'));
				$criteria->addSearchCondition('title', $search);
				$criteria->addSearchCondition('description', $search, true, 'or');
				$count = Video::model()->cache(Yii::app()->params['mediumCacheTime'])->count($criteria);
				if ($count > 0) {
					$savedSearch = new SavedSearchWords();
					$savedSearch->slug = $search;
					$savedSearch->type = 0;
					$savedSearch->save();
				}
				$pages = new CPagination($count);
				$pages->pageSize = Yii::app()->params['videosPerPage'];
				$orderString = Yii::app()->controller->module->chooseOrdering($_GET['order']);
				$criteria->order = $orderString;
				$pages->applyLimit($criteria);
				$videos = Video::model()->cache(Yii::app()->params['longCacheTime'])->findAll($criteria);
//				$categories=Yii::app()->controller->module->getCategories();
				$categories = VideoCategories::getCategoriesForDisplay();
				//meta tags
				Yii::import('application.modules.video.libraries.BMetaInformation');
				$metaInformation = new BMetaInformation();
				$metaInformation->setMetaInformation($this, BMetaInformation::PAGE_TYPE_SEARCH, $search, Yii::app()->controller->module->getVideoTagsForMetaTags($videos), '');
				//end meta tags

				$this->render('/default/browse', array('videos' => $videos,
					'pages' => $pages, 'categoriesWidgetData' => $categories,
					'orderingBaseUrl' => 'video/default/search&search=' . $search,
					'browseTitle' => $this->pageTitle));
			}
		} else {
			$this->redirect(array('/'));
		}
	}

	public function actionAjaxSearch() {
		if (isset($_REQUEST['search'])) {
			Yii::import('application.lib.AGSStringHelper');
			$stringHelper = new AGSStringHelper();
			$search = $stringHelper->prepare_string($_REQUEST['search']);
			if (strlen($search) > 2 and strlen($search) < 15) {
				$criteria = new CDbCriteria(array('condition' => 'status=1'));
				$criteria->addSearchCondition('title', $search);
				$criteria->addSearchCondition('description', $search, true, 'or');
				if (isset($_REQUEST['orderType'])) {
					if ($_REQUEST['orderType'] == 'date') {
						$criteria->order = 'publish_time';
					}
				}
				$numberOfVideos = Video::model()->cache(Yii::app()->params['mediumCacheTime'])->count($criteria);
				$criteria->limit = 12;
				$videos = Video::model()->cache(Yii::app()->params['mediumCacheTime'])->findAll($criteria);

				$this->renderPartial('ajaxSearch', array('search' => $search,
					'videos' => $videos, 'videoId' => $_REQUEST['videoId'],
					'numberOfVideos' => $numberOfVideos));
				Yii::app()->end();
			}
		}
		$this->renderPartial('ajaxSearch', array('search' => ''));
	}

	public function actionTagSearch() {
		if (isset($_REQUEST['as_values_1'])) {
			$tagIds = explode(',', $_REQUEST['as_values_1']);
			$preparedTags = array();
			$tagString = '';
			$paginationParameter = '';
			foreach ($tagIds as $k => $tagId) {
				if (is_numeric($tagId) == true) {
					$preparedTags[':tag' . $k] = (int) $tagId;
					$tagString = $tagString . ',:tag' . $k;
					$paginationParameter = $paginationParameter . ',' . $tagId;
				}
			}
			if ($tagString != '') {
				$tagString = substr($tagString, 1);
				$paginationParameter = substr($paginationParameter, 1);
				$sql = 'SELECT count(*)
					FROM {{video}} AS v
					INNER JOIN {{video_tags_lookup}} AS l
					ON (v.video_id=l.video_id)
					WHERE v.status=1
					AND l.tag_id IN (' . $tagString . ')';
				$count = Video::model()->cache(Yii::app()->params['mediumCacheTime'])->countBySql($sql, $preparedTags);
				$pages = new CPagination($count);
				$pages->pageSize = Yii::app()->params['videosPerPage'];
				if (isset($_GET['order'])) {
					$pages->params = array('as_values_1' => $paginationParameter, 'order' => $_GET['order']);
				} else {
					$pages->params = array('as_values_1' => $paginationParameter);
				}
				$sql = 'SELECT v.*
					FROM {{video}} AS v
					INNER JOIN {{video_tags_lookup}} AS l
					ON (v.video_id=l.video_id)
					WHERE v.status=1
					AND l.tag_id IN (' . $tagString . ') 
					ORDER BY v.video_id DESC
					LIMIT ' . $pages->getLimit() . '
					OFFSET ' . $pages->getOffset();
				$videos = Video::model()->cache(Yii::app()->params['longCacheTime'])->findAllBySql($sql, $preparedTags);
//				$categories=Yii::app()->controller->module->getCategories();
				$categories = VideoCategories::getCategoriesForDisplay();

				$this->render('/default/browse', array('videos' => $videos,
					'pages' => $pages, 'categoriesWidgetData' => $categories,
					'orderingBaseUrl' => 'video/default/tagSearch?as_values_1=' . $paginationParameter));
			} else {
				$this->redirect(array('/'));
			}
		} else {
			$this->redirect(array('/'));
		}
	}

	public function actionGetPossibleSearchStrings() {
		if (isset($_GET['search'])) {
			Yii::import('application.lib.AGSStringHelper');
			$stringHelper = new AGSStringHelper();
			$search = $stringHelper->prepare_string($_GET['search']);
			if (strlen($search) > 2 and strlen($search) < 15) {
				$search = mysql_escape_string($search);
				$sql = 'SELECT *
					FROM {{video_tags}}
					WHERE name LIKE \'' . $search . '%\'
					LIMIT 10';
				$tags = VideoTags::model()->cache(Yii::app()->params['longCacheTime'])->findAllBySql($sql);
				$data = array();
				foreach ($tags as $tag) {
					$json = array();
					$json['value'] = $tag->tag_id;
					$json['name'] = $tag->name;
					$json['image'] = null;
					$data[] = $json;
				}
				header("Content-type: application/json");
				echo json_encode($data);
				exit;
			}
		}
	}

	public function actionRedirect() {
		header('Location: http://' . urldecode($_GET['link']));
		exit;
	}

}
