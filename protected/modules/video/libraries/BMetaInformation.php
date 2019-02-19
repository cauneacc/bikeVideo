<?php

class BMetaInformation{
	const PAGE_TYPE_VIDEO_VIEW='videoView';
	const PAGE_TYPE_VIDEO_CATEGORY='videoCategory';
	const PAGE_TYPE_TAG='tag';
	const PAGE_TYPE_SEARCH='search';
	const PAGE_TYPE_DEFAULT='default';
	static $searchArray=array('$title','$description','$keywords');
	/**
	 *
	 * @param string $pageType - available values default, tag, search, videoVies, videoCategory
	 */
	public function setMetaInformation(&$controllerInstance, $pageType, $title, $keywords, $description){
		$searchArray=array('$title','$description','$keywords');
		$replaceArray=array($title,$description,$keywords);
		if(empty($title) == false){
			if(isset(Yii::app()->params[$pageType.'PageTitle'])){
				$controllerInstance->pageTitle=str_replace(self::$searchArray, $replaceArray, Yii::app()->params[$pageType.'PageTitle']);
			}else{
				$controllerInstance->pageTitle=$title;
			}
		}else{
			$controllerInstance->pageTitle=str_replace(self::$searchArray, array('','',''), Yii::app()->params['defaultPageTitle']);
		}
		if(empty($keywords) == false){
			if(isset(Yii::app()->params[$pageType.'Keywords'])){
				Yii::app()->clientScript->registerMetaTag(str_replace(self::$searchArray, $replaceArray, Yii::app()->params[$pageType.'Keywords']),'keywords');
			}else{
				Yii::app()->clientScript->registerMetaTag($keywords, 'keywords');
			}
		}else{
			Yii::app()->clientScript->registerMetaTag(str_replace(self::$searchArray, array('','',''),Yii::app()->params['defaultKeywords']), 'keywords');
		}
		if(empty($description) == false){
			if(isset(Yii::app()->params[$pageType.'Description'])){
				Yii::app()->clientScript->registerMetaTag(str_replace(self::$searchArray, $replaceArray, Yii::app()->params[$pageType.'Description']), 'description');
			}else{
				Yii::app()->clientScript->registerMetaTag($description, 'description');
			}
		}else{
			Yii::app()->clientScript->registerMetaTag(str_replace(self::$searchArray, array('','',''),Yii::app()->params['defaultDescription']), 'description');
		}
	}

	public function setDefaultMetaInformation(&$controllerInstance){
		$controllerInstance->pageTitle=str_replace(self::$searchArray, array('','',''),Yii::app()->params['defaultPageTitle']);
		Yii::app()->clientScript->registerMetaTag(str_replace(self::$searchArray, array('','',''),Yii::app()->params['defaultKeywords']), 'keywords');
		Yii::app()->clientScript->registerMetaTag(str_replace(self::$searchArray, array('','',''),Yii::app()->params['defaultDescription']), 'description');
	}

}

?>
