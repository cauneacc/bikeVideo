<?php

class SeoKeywordsPage extends CActiveRecord {

	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{seo_keywords_page}}';
	}

	static function saveGoogleKeyword() {
//		$_SERVER['HTTP_REFERER']='http://www.google.fr/#q=enculeuse&hl=fr&prmd=imvnsl&ei=OtrlTtb0A5Ge-waf8aHHBQ&start=20&sa=N&bav=on.2,or.r_gc.r_pw.,cf.osb&fp=bc039a4d90b8c7cd&biw=1303&bih=954';
		if (isset($_SERVER['HTTP_REFERER'])) {
			$db = Yii::app()->db;
			$start = strpos($_SERVER['HTTP_REFERER'], 'q=');
			if ($start) {
				$start = $start + 2;
				$keywords = substr($_SERVER['HTTP_REFERER'], $start, strpos($_SERVER['HTTP_REFERER'], '&', $start) - $start);
				$keywords = trim(urldecode($keywords));
				$sql = 'select count(*) as count
						from {{keywords_blacklist}} 
						where word=:word';
				$command = $db->createCommand($sql);
				$command->bindParam(':word', $keywords);
				$blacklistedWords = $command->queryRow();
				if ($blacklistedWords['count'] == 0) {
					$sql = 'insert ignore into {{seo_keywords_page}} 
						(word,page) values (:word,:page)
						ON DUPLICATE KEY UPDATE number_of_searches=number_of_searches+1';
					$command = $db->createCommand($sql);
					$command->bindParam(':word', $keywords);
					$a = Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id;
					$command->bindParam(':page', $_SERVER['REQUEST_URI']);
					$command->execute();
				}
			}
		}
	}

	static function putSeoKeywordsToAllSites(&$fileHandle, &$db,&$urlManager) {
//		$_SERVER['SERVER_NAME']=$hostname;
		$command = $db->createCommand('INSERT ignore INTO {{seo_keywords_page}} (word,page,status,number_of_searches) 
			VALUES (:word,:page,1,1)');
		$tagsCommand = $db->createCommand('SELECT v.video_id,v.slug 
			FROM {{video}} AS v 
			INNER JOIN {{video_tags_lookup}} AS l 
			ON (v.video_id=l.video_id) 
			INNER JOIN {{video_tags}} AS t 
			ON (l.tag_id=t.tag_id)
			WHERE t.name=:word
			AND v.status=1
			ORDER BY rand() LIMIT 1');
		$randomVideoCommand = $db->createCommand('SELECT video_id, slug FROM {{video}} WHERE status=1 ORDER BY rand() LIMIT 1');
		$counter = 0;
		$errors = 0;
		while (($buffer = fgets($fileHandle, 4096)) !== false and $errors < 100) {
			$data = @unserialize($buffer);
			if ($data != false) {
				if (isset($data['word'])) {
					$tagsCommand->bindParam(':word', $data['word']);
					$video = $tagsCommand->queryRow();
					if (!$video) {
						$video = $randomVideoCommand->queryRow();
					}
					if ($video) {//maybe there aren't any videos in the database
						$page = $urlManager->createUrl('video/default/view', array('id' => $video['video_id'], 'slug' => $video['slug']));
						$command->bindParam(':word', $data['word']);
						$command->bindParam(':page', $page);
						$command->execute();
						$counter=$counter+1;
					}
				}
			} else {
				$errors = $errors + 1;
			}
//			if ($counter % 1000 == 0) {
//				sleep(1);
//			}
		}
		echo $counter.  PHP_EOL;
		if ($errors >= 100) {
			echo ' mai mult de 100 de erori'.  PHP_EOL;
			Yii::log('Too many errors while unserializing data from the downloaded file.', 'error', __CLASS__);
		}
	}

}

?>