<?php

class ManagementController extends Controller {

	public function actionTest() {
		throw new CHttpException(404);

		header('HTTP/1.1 200 OK');
		echo 'success';
		exit;
	}

	public function actionCreateSites() {
		/*
		 * receives data from project masterControl /protected/modules/masterControl/libraries/remoteInstall/AgsiRemoteInstall.php
		 * called from /protected/modules/masterControl/controllers/InstallSiteController.php actionIndex
		 */
		if (is_dir(Yii::getPathOfAlias('application.config.original'))) {
			$receivedDataArray = @unserialize($_POST['s']);
			if ($receivedDataArray) {
				if (is_array($receivedDataArray)) {
					foreach ($receivedDataArray as $key => $receivedData) {
						$result[$key] = false;
						if (isset($receivedData['url'])) {
							$siteName = trim($receivedData['url'], '/');
							Yii::import('application.modules.api.libraries.remoteInstall.AgsiPinklionApi');
							$pinklionApi = new AgsiPinklionApi();
							//set no ip
							$createSiteResult = $pinklionApi->createHosting($siteName, '');
							Yii::log('pinklion result "' . var_export($createSiteResult, true) . '".', 'error', __CLASS__);

							if (is_array($createSiteResult)) {
								if (empty($createSiteResult['result'])) {
									unset($receivedDataArray[$key]);
									Yii::log('Pinklion api could not create the domain "' . $siteName . '".The response received was "' . $createSiteResult[1] . '".', 'error', __CLASS__);
								}
							}
						} else {
							unset($receivedDataArray[$key]);
						}
					}
					sleep(4);
					$result = array();
					foreach ($receivedDataArray as $key => $receivedData) {
						$siteName = trim($receivedData['url'], '/');
						$newDbData = $pinklionApi->getHostingInformation($siteName);
						if (is_array($newDbData)) {
							if (empty($newDbData['sql_login']) == false) {
								$targetFolder = Yii::getPathOfAlias('application.config') . DIRECTORY_SEPARATOR . $siteName;
								if (is_dir($targetFolder)) {
//						exec('rm -rf ' . $targetFolder);
									Yii::log('Could not install site "' . $siteName . '", config folder already exists.', 'error', __CLASS__);
								} else {
									$this->recurse_copy(Yii::getPathOfAlias('application.config.original'), $targetFolder);
									if (is_dir($targetFolder)) {
										$sitemapFolder = Yii::getPathOfAlias('webroot.sitemaps') . DIRECTORY_SEPARATOR . $siteName;
										if (mkdir($sitemapFolder) == false) {
											Yii::log('Could not create sitemap folder "' . $sitemapFolder . '".', 'error', __CLASS__);
										} else {
											$aux = require($targetFolder . DIRECTORY_SEPARATOR . 'params.php');
											$aux['rootUrl'] = 'http://' . $siteName . '/';
											$siteTitle = $receivedData['title'];
											$aux['siteName'] = $siteTitle;
											$aux['bstatsId'] = $receivedData['id'];
											$aux = array_merge($aux, $receivedData['metaInformation']);
											$paramsFilePath = $targetFolder . DIRECTORY_SEPARATOR . 'params.php';
											if (file_put_contents($paramsFilePath, '<?php return ' . var_export($aux, true) . '; ?>') == true) {
												$aux = file_get_contents($targetFolder . DIRECTORY_SEPARATOR . 'main.php');
												$aux = preg_replace("/'theme'=>'[a-zA-z0-9-\._ ]+',/", "'theme'=>'" . $receivedData['theme'] . "',", $aux);
												$aux = preg_replace("/'name'=>'[a-zA-z0-9-\._ ]+',/", "'name'=>'" . $siteTitle . "',", $aux);
												$aux = preg_replace("/'language'=>'[a-zA-z0-9-\._ ]+',/", "'language'=>'" . $receivedData['languageShort'] . "',", $aux);
												$mainConfigurationFilePath = $targetFolder . DIRECTORY_SEPARATOR . 'main.php';
												if (file_put_contents($mainConfigurationFilePath, $aux) == true) {
													$routingRulesFilePath = $targetFolder . DIRECTORY_SEPARATOR . 'urls.php';
													if ($this->adRoutingRulesToFile($routingRulesFilePath, $routingRulesFilePath, $receivedData['routingRules']) == true) {
														$aux = require($targetFolder . DIRECTORY_SEPARATOR . 'applicationDb.php');
														$aux['connectionString'] = 'mysql:host=localhost;dbname=' . $newDbData['sql_login'];
														$aux['username'] = $newDbData['sql_login'];
														$aux['password'] = $newDbData['sql_pass'];
														$applicationDbFilePath = $targetFolder . DIRECTORY_SEPARATOR . 'applicationDb.php';
														if (file_put_contents($applicationDbFilePath, '<?php return ' . var_export($aux, true) . '; ?>') == true) {
															$availableSitesFilePath = Yii::getPathOfAlias('application.config') . DIRECTORY_SEPARATOR . 'availableSites.php';
															$aux = require($availableSitesFilePath);
															$aux[] = $siteName;
															$aux = array_unique($aux);
															$r = file_put_contents($availableSitesFilePath, '<?php return ' . var_export($aux, true) . '; ?>');
															if ($r !== false) {
																$mysqlEditedDumpPath = Yii::getPathOfAlias('application.runtime.mysql') . '-' . $siteName . '.sql';
																Yii::import('application.modules.api.libraries.remoteInstall.AgsiDatabaseInstallHelper');
																$dbHelper = new AgsiDatabaseInstallHelper();
																if ($dbHelper->editDatabaseDump($receivedData['languageId'], $siteName, $mysqlEditedDumpPath)) {
																	if ($dbHelper->importMysqlData('localhost', $newDbData['sql_login'], $newDbData['sql_pass'], $newDbData['sql_login'], $mysqlEditedDumpPath)) {
																		$result[$key] = true;
																		Yii::log('a reusit instalarea site-ului "' . $siteName . '"', 'warning', __CLASS__);
																	}
																} else {
																	Yii::log('Could not edit databasedump.', 'error', __CLASS__);
																}
															} else {
																Yii::log('Could not write file "' . $availableSitesFilePath . '".', 'error', __CLASS__);
															}
														} else {
															Yii::log('Could not write file "' . $applicationDbFilePath . '".', 'error', __CLASS__);
														}
													} else {
														Yii::log('Could not add routing rules to file "' . $routingRulesFilePath . '".', 'error', __CLASS__);
													}
												} else {
													Yii::log('Could not write to file "' . $mainConfigurationFilePath . '".', 'error', __CLASS__);
												}
											} else {
												Yii::log('Could not write to file "' . $paramsFilePath . '".', 'error', __CLASS__);
											}
											if ($result[$key] == false) {
												Yii::log('Failed creating site "' . var_export($siteName, true) . '", trying to delete it.', 'warning', __CLASS__);
												$this->deleteSite($siteName);
											}
										}
									} else {
										Yii::log('Failed to copy config folder to path "' . $targetFolder . '".', 'error', __CLASS__);
									}
								}
							} else {
								if ($newDbData[1]) {
									Yii::log('Failed to get site information from pinklion api for site "' . $siteName . '". The error received was "' . $newDbData[1] . '"', 'error', __CLASS__);
								} else {
									Yii::log('Could not get site information from pinklion api for site "' . $siteName . '. The BPinklionApi getSiteData() method returned "' . var_export($newDbData, true) . '"', 'error', __CLASS__);
								}
							}
						} else {
							Yii::log('Could not get site information from pinklion api for site "' . $siteName . '. The BPinklionApi getSiteData() method returned "' . var_export($newDbData, true) . '"', 'error', __CLASS__);
						}
					}
					//aici trebuie scris rezultatul	
					Yii::log('raspunsul trimis "' . var_export($result, true) . '"', 'warning', __CLASS__);
					echo serialize($result);
				}
			} else {
				Yii::log('Faile to unserialize the information received. The information received was  "' . var_export($_POST['s'], true) . '"', 'warning', __CLASS__);
			}
		} else {
			Yii::log('Original config folder "' . Yii::getPathOfAlias('application.config.original') . '" does not exist .', 'error', __CLASS__);
		}
	}

	public function adRoutingRulesToFile($sourceRulesFile, $targetRulesFile, $rules) {
		$availableRules = array('video/<id:\d+>/<slug>' => 'video/default/view',
			'videos_<slug>_<id:\d+>' => 'video/categories/index',
			'tag/<slug>.html' => 'video/tags/index',
		);

		$a = require $sourceRulesFile;
		if (is_array($a)) {
			if (is_array($a['rules'])) {
				foreach ($availableRules as $key => $value) {
					$existingKey = array_search($value, $a['rules']);
					if ($existingKey !== false) {
						unset($a['rules'][$existingKey]);
					}
					$a['rules'][$rules[$value]] = $value;
				}
			} else {
				Yii::log('The file "' . $file . '" is malformed', 'error', 'BRoutingRules');
				return false;
			}
			return file_put_contents($targetRulesFile, '<?php return ' . var_export($a, true) . '?>');
		} else {
			Yii::log('The file "' . $sourceRulesFile . '" could not be read or is malformed', 'error', 'BRoutingRules');
			return false;
		}
	}

	private function recurse_copy($src, $dst) {
		$dir = opendir($src);
		@mkdir($dst);
		while (false !== ( $file = readdir($dir))) {
			if (( $file != '.' ) && ( $file != '..' )) {
				if (is_dir($src . '/' . $file)) {
					recurse_copy($src . '/' . $file, $dst . '/' . $file);
				} else {
					copy($src . '/' . $file, $dst . '/' . $file);
				}
			}
		}
		closedir($dir);
	}

	private function deleteConfigFolder($siteName) {
		$targetFolder = Yii::getPathOfAlias('application.config') . DIRECTORY_SEPARATOR . $siteName;
		if (is_dir($targetFolder)) {
			$this->rrmdir($targetFolder);
			if (is_dir($targetFolder)) {
				Yii::log('Failed to delete configuration folder "' . $targetFolder . '"', 'error', __CLASS__);
				return false;
			} else {
				return true;
			}
		} else {
			Yii::log('Tried to delete configuration folder "' . $targetFolder . '". Folder does not exist.', 'error', __CLASS__);
			return true;
		}
	}

	private function deleteSitemapFolder($siteName) {
		$sitemapFolder = Yii::getPathOfAlias('webroot.sitemaps') . DIRECTORY_SEPARATOR . $siteName;
		if (is_dir($sitemapFolder)) {
			$this->rrmdir($sitemapFolder);
			if (is_dir($sitemapFolder)) {
				Yii::log('Failed to delete sitemap folder "' . $sitemapFolder . '"', 'error', __CLASS__);
				return false;
			} else {
				return true;
			}
		} else {
			return true;
		}
	}

	public function actionDeleteMultipleSites() {
		$receivedData = @unserialize($_POST['s']);
		if ($receivedData) {
			$result = array();
			foreach ($receivedData as $key => $url) {
				$siteName = trim($url, '/');
				$result[$key] = $this->deleteSite($siteName);
			}
			echo serialize($result);
		}
	}

	private function rrmdir($dir) {
		foreach (glob($dir . '/*') as $file) {
			if (is_dir($file))
				rrmdir($file);
			else
				unlink($file);
		}
		rmdir($dir);
	}

	protected function deleteSite($siteName) {
		$errorMessages = '';
		Yii::import('application.modules.api.libraries.remoteInstall.AgsiPinklionApi');
		$pinklionApi = new AgsiPinklionApi();
		$result = $pinklionApi->deleteHosting($siteName);
		if ($result == false) {
			Yii::log('Failed to delete site "' . $siteName . '" through pinklion api. The response received was "' . var_export($result, true) . '"', 'error', __CLASS__);
			$errorMessages = 'Error deleting hosting and database.';
		}
		$targetFolder = Yii::getPathOfAlias('application.config') . DIRECTORY_SEPARATOR . $siteName;
		if (is_dir($targetFolder)) {
			if ($this->deleteConfigFolder($siteName)) {
				if ($this->deleteSitemapFolder($siteName)) {
					return true;
				} else {
					$errorMessages = $errorMessages . 'Error deleting sitemaps folder.';
				}
			} else {
				$errorMessages = $errorMessages . 'Error deleting config folder.';
			}
		} else {
			if ($this->deleteSitemapFolder($siteName)) {
				return true;
			} else {
				$errorMessages = $errorMessages . 'Error deleting sitemaps folder.';
			}
		}
		if ($errorMessages != '') {
			Yii::log('Error while deleting site "' . $siteName . '". The errors are "' . $errorMessages . '"', 'error', __CLASS__);
			return false;
		}
	}

	public function actionGetAvailableThemes() {
		Yii::import('application.modules.api.libraries.remoteInstall.AgsiThemesHelper');
		$themeHelper = new AgsiThemesHelper();
		echo serialize($themeHelper->getAvailableThemes());
	}

	public function actionGetVideoCountForAllSites() {
		$results=array();
		$configs = $this->module->getDbConfigForAvailableSites();
		foreach ($configs as $site => $config) {
			$dbh = new PDO($config['connectionString'], $config['username'], $config['password']);
			$sql = 'SELECT count(*) as count from ' . $config['tablePrefix'] . 'video';
			$count = $dbh->query($sql)->fetch();
			$results[] = array($site, $count['count']);
			$dbh = null;
		}
		echo serialize($results);
	}

}
