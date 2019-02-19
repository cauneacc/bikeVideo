<?php

class VideoController extends Controller {

	public function actionCategories() {
		$connection = Yii::app()->db;
		$categories = $connection->createCommand('select * from {{video_categories}}')->queryAll();
		echo serialize($categories);
	}

	public function actionPutVideo() {
		Yii::import('ext.crawlers.BCrawler');
		$videoModel = new Video();
		if ($videoModel->add_video($_POST)) {
			header('HTTP/1.1 200 OK');
			echo 'Success';
			exit;
		} else {
			header('HTTP/1.1 404 Not Found');
			echo 'Error';
			exit;
		}
	}

	public function actionGetVideoMasterControlIds() {
		$command = Yii::app()->db->createCommand('select distinct master_control_id from {{video}}');
		$result = $command->queryAll();
		echo serialize($result);
	}

	public function actionUpdateVideoCategory() {
		$sql = 'insert ignore into {{video_category}} (cat_id, video_id, parent_cat_id) values (:catId,:videoId,:parentCatId)';
		$command = Yii::app()->db->createCommand($sql);
		$max = count($_POST);

		for ($i = 0; $i < $max; $i++) {
			$sql = 'select video_id from {{video}} where master_control_id =:masterControlId';
			$command1 = Yii::app()->db->createCommand($sql);
			$command1->bindParam(':masterControlId', $_POST[$i][1]);
			$videoId = $command1->queryRow();
			if ($videoId) {
				$command->bindParam(':catId', $_POST[$i][0]);
				$command->bindParam(':videoId', $videoId['video_id']);
				$command->bindParam(':parentCatId', $_POST[$i][2]);
				$command->execute();
			}
		}
		echo 'success';
	}

	public function actionSignalImportVideo() {
		if (isset($_POST['fileUrl'])) {
			Yii::import('ext.crawlers.libraries.BCurl');
			$bCurl = new BCurl();
			$fileName = trim($_POST['fileUrl'], '/');
			$fileName = substr($fileName, strrpos($fileName, '/'));
			$filePath = realpath(dirname(__FILE__) . '/../../../runtime/tmp/downloads'). $fileName;
			$yiicCommandPath=realpath(dirname(__FILE__) . '/../../../yiic.php');
			if ($bCurl->file($_POST['fileUrl'], $filePath)) {
				if (is_file($filePath)) {
					exec('nohup php '.$yiicCommandPath.' importVideosFromFile '.$filePath.' --config='.$_SERVER['SERVER_NAME'].' >/dev/null 2>&1 &');
//					echo 'nohup php '.$yiicCommandPath.' importVideosFromFile '.$filePath.' >/dev/null 2>&1 &'.  PHP_EOL;
					echo 'success';
					Yii::app()->end();
				} else {
					Yii::log('Could not find downloaded file. The file path is "' . $filePath . '"', 'error', __CLASS__);
					$this->respondError();
				}
			} else {
				Yii::log('Could not download file to import videos. The url used is "' . $_POST['fileUrl'] . '"', 'error', __CLASS__);
				$this->respondError();
			}
		}
	}

	private function respondError() {
		header('HTTP/1.1 404 Not Found');
		echo 'error';
		Yii::app()->end();
	}

}
