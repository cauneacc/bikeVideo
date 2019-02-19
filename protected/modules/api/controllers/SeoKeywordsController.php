<?php

class SeoKeywordsController extends Controller {

	public function actionAddWordToBlacklist() {
		if ($_POST['word']) {
			$db = Yii::app()->db;
			$command = $db->createCommand('insert ignore into {{keywords_blacklist}}
				(word) values (:word)');
			$command->bindParam(':word', $_POST['word']);
			if ($command->execute()) {
				unset($command);
				$command = $db->createCommand('delete ignore from {{seo_keywords_page}} where word=:word');
				$command->bindParam(':word', $_POST['word']);
				if ($command->execute()) {
					header('HTTP/1.1 200 OK');
					echo 'Success';
					exit;
				}
			}
		}
		header('HTTP/1.1 404 Not Found');
		echo 'Error';
		exit;
	}

	public function actionDeleteWordFromBlacklist() {
		if ($_POST['word']) {
			$db = Yii::app()->db;
			$command = $db->createCommand('delete from {{keywords_blacklist}}
				where word=:word');
			$command->bindParam(':word', $_POST['word']);
			if ($command->execute()) {
				header('HTTP/1.1 200 OK');
				echo 'Success';
				exit;
			}
		}
		header('HTTP/1.1 404 Not Found');
		echo 'Error';
		exit;
	}

	public function actionDeactivateSeoPageGeneration() {
		$configPath = Yii::getPathOfAlias('application.config.custom.unifiedConfiguration') . '.php';
		$config = require($configPath);
		$config['seoPageGenerationActivated'] = 0;
		if (file_put_contents($configPath, '<?php return ' . var_export($config, true) . '?>')) {
			header('HTTP/1.1 200 OK');
			echo 'success';
			exit;
		} else {
			header('HTTP/1.1 404 Not Found');
			echo 'error';
			exit;
		}
	}

	public function actionActivateSeoPageGeneration() {
		$configPath = Yii::getPathOfAlias('application.config.custom.unifiedConfiguration') . '.php';
		$config = require($configPath);
		$config['seoPageGenerationActivated'] = 1;
		if (file_put_contents($configPath, '<?php return ' . var_export($config, true) . '?>')) {
			header('HTTP/1.1 200 OK');
			echo 'success';
			exit;
		} else {
			header('HTTP/1.1 404 Not Found');
			echo 'error';
			exit;
		}
	}

	public function actionGetKeywords() {
		$db = Yii::app()->db;
		$command = $db->createCommand('select * from {{seo_keywords_page}} order by number_of_searches desc');
		$result = $command->queryAll();
		if (is_array($result)) {
			echo serialize($result);
		} else {
			header('HTTP/1.1 404 Not Found');
			echo 'error';
			exit;
		}
	}

	public function actionGetConfiguration() {
		$configPath = Yii::getPathOfAlias('application.config.custom.unifiedConfiguration') . '.php';
		$config = require($configPath);
		$a = array('seoPageGenerationActivated' => $config['seoPageGenerationActivated'],
			'seoKeywordsToActivateDaily' => $config['seoKeywordsToActivateDaily'],
			'seoLinksToDisplay' => $config['seoLinksToDisplay']);
		echo serialize($a);
	}

	public function actionPutConfiguration() {
		$configPath = Yii::getPathOfAlias('application.config.custom.unifiedConfiguration') . '.php';
		$config = require($configPath);
		if (isset($_POST['seoKeywordsToActivateDaily'])) {
			if (is_numeric($_POST['seoKeywordsToActivateDaily'])) {
				$config['seoKeywordsToActivateDaily'] = $_POST['seoKeywordsToActivateDaily'];
			}
		}
		if (isset($_POST['seoLinksToDisplay'])) {
			if (is_numeric($_POST['seoLinksToDisplay'])) {
				$config['seoLinksToDisplay'] = $_POST['seoLinksToDisplay'];
			}
		}


		if (file_put_contents($configPath, '<?php return ' . var_export($config, true) . '?>')) {
			header('HTTP/1.1 200 OK');
			echo 'success';
			exit;
		} else {
			header('HTTP/1.1 404 Not Found');
			echo 'error';
			exit;
		}
	}

	//: nr de keyworduri generate pentru fiecare site / nr de pagini active
	public function actionGetPagesAndKeywords() {
		$db = Yii::app()->db;
		$command = $db->createCommand('SELECT count(*) AS count FROM (SELECT word FROM tbl_seo_keywords_page GROUP BY word) AS tab1');
		$keywords = $command->queryRow();
		$command = $db->createCommand('SELECT count(*) AS count FROM (SELECT word FROM tbl_seo_keywords_page WHERE status>0 GROUP BY word) AS tab1');
		$pages = $command->queryRow();
		echo serialize(array('keywords' => $keywords['count'], 'pages' => $pages['count']));
		exit;
	}

	public function actionGetSeoKeywordsForAllSites() {
		$fileName = crc32(Yii::app()->params['rootUrl'] . __METHOD__) . '-' . rand(0, 9999) . '.txt';
		$filePath = dirname(__FILE__) . '/../../../../apiDataFiles/' . $fileName;
		$fileHandle = fopen($filePath, 'w');
		if ($fileHandle) {
			$configs = $this->module->getDbConfigForAvailableSites();
			foreach ($configs as $site => $config) {
				$dbh = new PDO($config['connectionString'], $config['username'], $config['password']);
				if ($dbh) {
					$sql = 'select word from ' . $config['tablePrefix'] . 'seo_keywords_page where status=1 and word!=\'\' group by word';
					$statement=$dbh->prepare($sql);
					if($statement){
						$statement->execute();
						while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
							fwrite($fileHandle, str_replace("\n",'',serialize($row))."\n");
					    }
					}
					$dbh=null;
				}
			}
			fclose($fileHandle);
			exec('gzip -f ' . $filePath);
			if (is_file($filePath . '.gz')) {
				echo $fileName . '.gz';
			} else {
				Yii::log('Failed to gzip file "' . $filePath . '"', 'error', __CLASS__);
			}
		} else {
			Yii::log('Could not create or open file "' . $filePath . '"', 'error', __CLASS__);
		}
	}

	public function actionPutSeoKeywordsToAllSites() {
		if (isset($_POST['fileUrl'])) {
			Yii::import('application.modules.api.libraries.AgsiApiDataFile');
			$api = new AgsiApiDataFile();

			$filePath = $api->getFile($_POST['fileUrl']);
			if ($filePath) {
				$command = 'nohup php ' . dirname(__FILE__) . '/../../../yiic.php ImportSeoKeywordsForAllSitesFromFile ' . $filePath . ' --config=' . str_replace('http://', '', Yii::app()->params['rootUrl']) . '/ >'.dirname(__FILE__) . '/../../../importSeoKeywordsForAllSitesFromFile.log 2>&1 &';
				exec($command);
				return 'success';
			} else {
				header('HTTP/1.1 404 Not Found');
				echo 'error';
				Yii::app()->end();
			}
		}
	}

}
