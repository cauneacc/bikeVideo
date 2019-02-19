<?php

class ContentCategoriesController extends Controller {

	public function actionContentCategories(){
		if(isset($_POST['data'])){
			$data=@unserialize($_POST['data']);
			if($data){
				VideoCategories::model()->deleteAll();
				foreach($data as $row){
					$videoCategory=new VideoCategories();
					$videoCategory->cat_id=$row['cat_id'];
					$videoCategory->name=$row['name'];
					$videoCategory->description=$row['description'];
					$videoCategory->slug=$row['slug'];
					$videoCategory->status=$row['status'];
					$videoCategory->parent_cat_id=$row['parent_cat_id'];
					$videoCategory->image_name=$row['image_name'];
					if($videoCategory->save()==false){
						exit('db error');
					}
				}
				echo 'success';
			}elseif($data==false){
				echo 'malformed data received';
			}else{
				echo 'empty data';
			}
		}else{
			echo 'error';
		}
	}
	
	public function actionGetCategoriesImages(){
		$result=scandir(dirname(__FILE__).'/../../../../images/categories');
		asort($result);
		echo serialize($result);
	}
	
	public function actionPutCategoriesImages(){
		if(isset($_FILES['image'])){
			$imagesPath=dirname(__FILE__).'/../../../../images/categories';
			if(is_file($imagesPath)){
				if(unlink($imagesPath)==false){
					echo 'error';
					Yii::app()->end();
				}
			}
			if(move_uploaded_file($_FILES['image']['tmp_name'], $imagesPath.'/'.$_FILES['image']['name'])) {
				echo 'success';
			} else{
				echo 'error';
			}
		}
	}
}

?>
