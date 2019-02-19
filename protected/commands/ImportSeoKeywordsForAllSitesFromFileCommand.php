<?php

error_reporting(E_ALL & ~E_NOTICE);
set_time_limit(0);

class ImportSeoKeywordsForAllSitesFromFileCommand extends CConsoleCommand {

	public function run($args) {
		$_SERVER['SERVER_NAME'] = '';
		if (isset($args[0])) {
			$fileHandle = fopen($args[0], 'r');
			$availableSites = require(dirname(__FILE__) . '/../config/availableSites.php');
			if (is_array($availableSites)) {
				$max = count($availableSites);
				echo 'cate site-uri ar trebui sa faca '.$max.  PHP_EOL;
				for ($i = 0; $i < $max; $i++) {
					if ($availableSites[$i] != 'sites1.bigbang-1.com' and $availableSites[$i] != 'sites2.bigbang-1.com') {
						echo $availableSites[$i] . PHP_EOL;
						$urlConfigPath = dirname(__FILE__) . '/../config/' . $availableSites[$i] . '/urls.php';
						if (is_file($urlConfigPath)) {
							$urlManager = new CUrlManager();
							$urlManager->baseUrl = '';
							$urlConfig = require($urlConfigPath);
							$urlManager->addRules($urlConfig['rules']);
							$urlManager->urlFormat = $urlConfig['urlFormat'];
							$urlManager->showScriptName = $urlConfig['showScriptName'];
//					$a=$urlManager->createUrl('video/default/browse');
							$configFilePath = dirname(__FILE__) . '/../config/' . $availableSites[$i] . '/applicationDb.php';
							if (is_file($configFilePath)) {
								$config = require($configFilePath);
								$connection = new CDbConnection($config['connectionString'], $config['username'], $config['password']);
								$connection->tablePrefix = $config['tablePrefix'];
								$connection->schemaCachingDuration = $config['schemaCachingDuration'];
								SeoKeywordsPage::putSeoKeywordsToAllSites($fileHandle, $connection, $urlManager);
								rewind($fileHandle);
								unset($config);
								unset($urlConfig);
								sleep(1);
							} else {
								echo 'nu exista fisierul "' . $configFilePath . '"' . PHP_EOL;
							}
						} else {
							echo 'nu exista fisierul "' . $urlConfigPath . '"' . PHP_EOL;
						}
					}
				}
			} else {
				echo 'could not get availableSites' . PHP_EOL;
			}
			fclose($fileHandle);
			unlink($args[0]);
		}
	}

}

?>
