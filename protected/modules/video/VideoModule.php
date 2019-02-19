<?php

class VideoModule extends CWebModule{

	public function init(){
		$this->setImport(array(
			'video.models.*',
			'video.components.*',
		));
	}

	public function beforeControllerAction($controller, $action){
		if(parent::beforeControllerAction($controller, $action)){
			$controller->layout='//layouts/main';
			return true;
		}
		else
			return false;
	}
/*
 * should be removed. in VideoCategories a new function was made getCategoriesForDisplay()
	public function getCategories(){
		$r=Yii::app()->cache->get('videoModule.getCategories');
		if($r == false){
			$categories=VideoCategories::model()->findAll(array('condition'=>'status=\'1\'', 'order'=>'parent_cat_id asc'));
			$parentCategories=array();
			foreach($categories as $k=>$category){
				if($category->parent_cat_id === '0'){
					$parentCategories[$category->cat_id]=array('category'=>$category,
						'url'=>Yii::app()->createUrl('video/categories/index', array('id'=>$category->cat_id, 'slug'=>$category->slug)),
						'child'=>array());
				}
			}
			foreach($categories as $k=>$category){
				if($category->parent_cat_id !== '0'){
					$aux=$parentCategories[$category->parent_cat_id]['child'];
					$aux[]=array('category'=>$category, 'url'=>Yii::app()->createUrl('video/categories/index', array('id'=>$category->cat_id, 'slug'=>$category->slug)));
					$parentCategories[$category->parent_cat_id]['child']=$aux;
				}
			}
			$r=array('categories'=>$parentCategories, 'rawCategories'=>$categories);
			Yii::app()->cache->set('videoModule.getCategories', $r);
		}
		return $r;
	}
*/
	public function chooseOrdering($order, $table=''){
		if(strlen($table) > 0){
			$table=$table.'.';
		}
		if(isset($order)){
			switch($order){
				case 'duration':
					$orderString=$table.'duration desc';
					break;
				case 'rating':
					$orderString=$table.'rating desc';
					break;
				case 'popular':
					$orderString=$table.'total_views desc';
					break;

				default:
					$orderString=$table.'video_id desc';
					break;
			}
		}else{
			$orderString=$table.'video_id desc';
		}
		return $orderString;
	}


	public function getVideoTagsForMetaTags($videos){
		$max=count($videos);
		$videoIds='';
		for($i=0; $i < $max; $i++){
			$videoIds=$videoIds.','.$videos[$i]->video_id;
		}
		$videoIds=substr($videoIds, 1);
		if($videoIds != ''){
			$sql='SELECT *
			FROM {{video_tags}} as t
			inner join {{video_tags_lookup}} as l
			on (t.tag_id=l.tag_id)
			where l.video_id in ('.$videoIds.')';
			$tags=VideoTags::model()->cache(Yii::app()->params['longCacheTime'])->findAllBySql($sql);
			$max=count($tags);
			$aux=array();
			for($i=0; $i < $max; $i++){
				$aux[]=$tags[$i]->name;
			}
			return implode(',', array_slice(array_unique($aux),0,10));
		}else{
			return '';
		}
	}

}
