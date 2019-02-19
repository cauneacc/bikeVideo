<?php
class RatingController extends Controller{
	public function actionIndex(){
		if(isset($_POST['id'])==true and ($_POST['name']=='up' or $_POST['name']=='down')){
			if(is_numeric($_POST['id'])==true){
				$video=Video::model()->findByPk($_POST['id']);
				if($video){
					if($_POST['name']==='up'){
						$video->rated_up=$video->rated_up+1;
					}elseif($_POST['name']==='down'){
						$video->rated_down=$video->rated_down+1;
					}
					$video->rated_by=$video->rated_by+1;
					if($video->rated_down==0){
						$down=1;
					}else{
						$down=$video->rated_down;
					}
					$video->rating=$video->rated_up/$down;
					$video->save();
					
//					if($video->rated_by!=0){
//						$upWidth=$video->rated_up/$video->rated_by*630;
//						$downWidth=$video->rated_down/$video->rated_by*630;
//					}else{
//						$upWidth=0;
//						$downWidth=0;
//					}
					$this->renderPartial('index',array('video'=>$video));


				}else{
					header('HTTP/1.1 404 Not Found');
				}

			}else{
				header('HTTP/1.1 404 Not Found');
			}
		}else{
			header('HTTP/1.1 404 Not Found');
		}
	}
}
?>
