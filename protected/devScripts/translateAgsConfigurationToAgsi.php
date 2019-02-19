<?php

$handle = opendir('/home/sites');
if ($handle) {
	while (false !== ($entry = readdir($handle))) {
		if ($entry != '.' && $entry != '..' and $entry != '.maildir' and is_dir('/home/sites/' . $entry) == true and $entry != 'agsi') {

			echo $entry . PHP_EOL;
			if (is_dir('/home/sites/agsi/protected/config/' . $entry) == false) {
				exec('cp -R /home/sites/agsi/protected/config/original /home/sites/agsi/protected/config/' . $entry);
				if (is_file('/home/sites/' . $entry . '/www/protected/config/main.php')) {
					$config = require('/home/sites/' . $entry . '/www/protected/config/main.php');
					$filePath = '/home/sites/agsi/protected/config/' . $entry . '/main.php';
					$main = file_get_contents($filePath);
					$main = preg_replace("/'theme'=>'[a-zA-z0-9-\._ ]+',/", "'theme'=>'" . $config['theme'] . "',", $main);
					$main = preg_replace("/'name'=>'[a-zA-z0-9-\._ ]+',/", "'name'=>'" . $config['name'] . "',", $main);
					$main = preg_replace("/'language'=>'[a-zA-z0-9-\._ ]+',/", "'language'=>'" . $config['language'] . "',", $main);
					if (file_put_contents($filePath, $main)) {
						$filePath = '/home/sites/agsi/protected/config/' . $entry . '/applicationDb.php';
						$db = require($filePath);
						$db['connectionString'] = $config['components']['db']['connectionString'];
						$db['username'] = $config['components']['db']['username'];
						$db['password'] = $config['components']['db']['password'];
						if (file_put_contents($filePath, '<?php return ' . var_export($db, true) . ';?>')) {
							$filePath = '/home/sites/agsi/protected/config/' . $entry . '/params.php';
							$params = require($filePath);
							$params['rootUrl'] = $config['params']['rootUrl'];
							$params['defaultPageTitle'] = $config['params']['defaultPageTitle'];
							$params['defaultDescription'] = $config['params']['defaultDescription'];
							$params['defaultKeywords'] = $config['params']['defaultKeywords'];
							$params['tagPageTitle'] = $config['params']['tagPageTitle'];
							$params['tagDescription'] = $config['params']['tagDescription'];
							$params['tagKeywords'] = $config['params']['tagKeywords'];
							$params['searchPageTitle'] = $config['params']['searchPageTitle'];
							$params['searchDescription'] = $config['params']['searchDescription'];
							$params['searchKeywords'] = $config['params']['searchKeywords'];
							$params['videoViewPageTitle'] = $config['params']['videoViewPageTitle'];
							$params['videoViewDescription'] = $config['params']['videoViewDescription'];
							$params['videoViewKeywords'] = $config['params']['videoViewKeywords'];
							$params['videoCategoryPageTitle'] = $config['params']['videoCategoryPageTitle'];
							$params['videoCategoryDescription'] = $config['params']['videoCategoryDescription'];
							$params['videoCategoryKeywords'] = $config['params']['videoCategoryKeywords'];
							$params['siteName'] = $config['params']['siteName'];
							$params['masterControlRootUrl'] = 'http://static.' . $entry;
							$webAnalytics = file_get_contents('/home/sites/' . $entry . '/www/themes/webAnalyticsJsCode');
							$start = strpos($webAnalytics, 'images/webstats/pixel.php?u=');
							$sfarsit = strpos($webAnalytics, '"', $start);
							$params['bstatsId'] = substr($webAnalytics, $start + 28, $sfarsit - $start - 28);
							if (is_numeric($params['bstatsId']) == false) {
								echo ' nu am reusit sa gasesc bstatsId' . PHP_EOL;
							}
							$params['apiSalt'] = 'Daginstitutioner, skoler, fritidshjem, klubber, plejehjem, sociale institutioner, handicapcentre, administrationsejendomme, kulturhuse, museer, biblioteker, idratsanlag, brandstationer, tekniske bygninger mm.';
							if (file_put_contents($filePath, '<?php return ' . var_export($params, true) . ';?>')) {
								$filePath = '/home/sites/agsi/protected/config/' . $entry . '/urls.php';
								for ($i = 0; $i < 6; $i++) {
									if (isset($config['components']['urlManager']['rules'][$i])) {
										unset($config['components']['urlManager']['rules'][$i]);
									}
								}
								if (file_put_contents($filePath, '<?php return ' . var_export($config['components']['urlManager'], true) . '; ?>')) {
									$filePath = '/etc/nginx/sites/' . $entry;
									$nginxConfig = file_get_contents($filePath);
									$nginxConfig = str_replace($entry . '/www', 'agsi', $nginxConfig);
									if (file_put_contents($filePath, $nginxConfig)) {
										$filePath = '/home/sites/agsi/protected/config/availableSites.php';
										$availableSites = require($filePath);
										$availableSites[] = $entry;
										$availableSites = array_unique($availableSites);
										if (file_put_contents($filePath, '<?php return ' . var_export($availableSites, true) . '; ?>')) {
											$dbConn = mysql_connect('localhost', $config['components']['db']['username'], $config['components']['db']['password']);
											if ($dbConn) {
												if (mysql_select_db($config['components']['db']['username'], $dbConn)) {
													$sql = 'ALTER TABLE `tbl_video_categories` DROP COLUMN `adv`, DROP COLUMN `has_image`, ADD COLUMN `image_name` varchar(50)  NOT NULL AFTER `parent_cat_id`;';
													if (mysql_query($sql, $dbConn)) {
														$sql = 'update `tbl_video_categories` set `image_name`=  CONCAT(CAST(cat_id AS CHAR), \'default.png\');';
														if (mysql_query($sql, $dbConn)) {
															echo 'success' . PHP_EOL;
														} else {
															echo mysql_error($dbConn) . PHP_EOL;
														}
													} else {
														echo mysql_error($dbConn) . PHP_EOL;
													}
												} else {
													echo mysql_error($dbConn) . PHP_EOL;
												}

												mysql_close($dbConn);
											} else {
												echo mysql_error($dbConn) . PHP_EOL;
											}
										} else {
											echo 'nu am putut scrie in fisierul "' . $filePath . '"' . PHP_EOL;
										}
									} else {
										echo 'nu am putut scrie in fisierul "' . $filePath . '"' . PHP_EOL;
									}
								} else {
									echo 'nu am putut scrie in fisierul "' . $filePath . '"' . PHP_EOL;
								}
							} else {
								echo 'nu am putut scrie in fisierul "' . $filePath . '"' . PHP_EOL;
							}
						} else {
							echo 'nu am putut scrie in fisierul "' . $filePath . '"' . PHP_EOL;
						}
					} else {
						echo 'nu am putut scrie in fisierul "' . $filePath . '"' . PHP_EOL;
					}

					$config = null;
				} else {
					echo 'se pare ca nu e instalat ags pentru site-ul  "' . $entry . '"' . PHP_EOL;
				}
			} else {
				echo 'deja exista configuratia agsi pentru "' . $entry . '"' . PHP_EOL;
			}
		}
	}
	closedir($handle);
}
?>
