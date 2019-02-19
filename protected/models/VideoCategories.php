<?php

class VideoCategories extends CActiveRecord{
	const ENABLED='1';
	const DISABLED='0';

	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	public function tableName(){
		return '{{video_categories}}';
	}


	public static function getHierarchicalCategories(){
		$categories=self::model()->findAll();
		$parentCategories=array();
		foreach($categories as $k=>$category){
			if($category->parent_cat_id === '0'){
				$parentCategories[$category->cat_id]=array('category'=>$category,
					'child'=>array());
			}
		}
		foreach($categories as $k=>$category){
			if($category->parent_cat_id !== '0'){
				$aux=$parentCategories[$category->parent_cat_id]['child'];
				$aux[]=array('category'=>$category);
				$parentCategories[$category->parent_cat_id]['child']=$aux;
			}
		}
		return $parentCategories;
	}

	public static function getCategoriesForDisplay(){
		$r=Yii::app()->cache->get('videoCategories.getCategoriesForDisplay');
		if($r == false){
			$categories=self::model()->findAll(array('condition'=>'status=\'1\'', 'order'=>'parent_cat_id asc'));
			$parentCategories=array();
			foreach($categories as $k=>$category){
				if($category->parent_cat_id === '0'){
					$parentCategories[$category->cat_id]=array('category'=>$category,
						'url'=>Yii::app()->createUrl('video/categories/index', array('slug'=>$category->slug)),
						'child'=>array());
				}
			}
			foreach($categories as $k=>$category){
				if($category->parent_cat_id !== '0'){
					$aux=$parentCategories[$category->parent_cat_id]['child'];
					$aux[]=array('category'=>$category, 'url'=>Yii::app()->createUrl('video/categories/index', array('slug'=>$category->slug)));
					$parentCategories[$category->parent_cat_id]['child']=$aux;
				}
			}
			$r=array('categories'=>$parentCategories, 'rawCategories'=>$categories);
			Yii::app()->cache->set('videoCategories.getCategoriesForDisplay', $r);
		}
		return $r;
	}

}
