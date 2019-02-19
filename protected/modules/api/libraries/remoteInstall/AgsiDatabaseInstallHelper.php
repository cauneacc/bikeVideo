<?php

class AgsiDatabaseInstallHelper {

	function importMysqlData($host, $username, $password, $databaseName, $filePath) {
		$command = 'mysql -u ' . $username . ' --password=' . $password . ' ' . $databaseName . ' < ' . $filePath;
		exec($command, $output);
		if (count($output) == 0) {
			return true;
		} else {
			Yii::log('Could not import mysql dump into database "' . $databaseName . '". Error received: "' . var_export($output, true) . '".', 'error', __CLASS__);
			return false;
		}
	}

	function makeMysqlDatabaseAndUser($hostname) {
		$c = mysql_connect(Yii::app()->params['mysqlRootServer'], Yii::app()->params['mysqlRootUsername'], Yii::app()->params['mysqlRootPassword']);
		
		if (strlen($hostname) > 64) {
			$cleanHostname = preg_replace("/[^0-9a-zA-Z-]/", '', substr($hostname, 0, 50));
		} else {
			$cleanHostname = preg_replace("/[^0-9a-zA-Z-]/", '', $hostname);
		}
		if (strlen($hostname) > 16) {
			$cleanUsername = substr($cleanHostname, 0, 10);
		} else {
			$cleanUsername = $cleanHostname;
		}
		if (empty($cleanUsername) == false and empty($cleanHostname) == false) {
			$r = false;
			$i = 0;
			while ($r == false and $i < 10) {
				if ($i > 0) {
					$dbName = $cleanHostname . $i;
				} else {
					$dbName = $cleanHostname;
				}
				$sql = 'CREATE DATABASE ' . mysql_escape_string($dbName) . ';';
				$r = mysql_query($sql, $c);
				$i = $i + 1;
			}
			if ($i == 10 or $r == false) {
				Yii::log('Could not create an unused database name for hostname ' . $hostname, 'error', __CLASS__);
				return false;
			} else {
				$r = false;
				$i = 0;
				while ($r == false and $i < 10) {
					if ($i > 0) {
						$dbUser = $cleanUsername . $i;
					} else {
						$dbUser = $cleanUsername;
					}
					$sql = 'SELECT 1 FROM mysql.user WHERE user = \'' . mysql_escape_string($dbUser) . '\';';
					$r = mysql_query($sql, $c);
					if (mysql_num_rows($r) == 0) {
						$dbPassword = $this->generatePassword();
						$sql = 'grant all on ' . $dbName . '.* to \'' . mysql_escape_string($dbUser) . '\'@\'localhost\' identified by \'' . $dbPassword . '\'';
						$r = mysql_query($sql, $c);
						if($r==false){
							Yii::log(mysql_error(), 'error', __CLASS__);
						}else{
							mysql_query('flush privileges',$c);
						}
					} else {
						$r = false;
					}
					$i = $i + 1;
				}
				if ($i == 10 or $r == false) {
					Yii::log('Could not create an unused database user name or could not create a database user ', 'error', __CLASS__);
					$sql = 'drop database ' . mysql_escape_string($dbName) . ';';
					if (mysql_query($sql, $c) == false) {
						Yii::log('Could not clean database. Could drop database ' . mysql_escape_string($dbName) . ' ', 'error', __CLASS__);
					}
					mysql_close($c);
					return false;
				}
				mysql_close($c);
				return array('name' => $dbName, 'user' => $dbUser, 'password' => $dbPassword);
			}
		} else {
			Yii::log('Failed to create clean username and database name for hostname "' . $hostname . '".', 'error', __CLASS__);
			return false;
		}
	}

	function generatePassword($taille = 10) {
		$caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		srand((double) microtime() * 1000000);
		for ($i = 0; $i < $taille; $i++)
			$motdepasse.=substr($caracteres, rand(0, strlen($caracteres) - 1), 1);
		return $motdepasse;
	}

	public function editDatabaseDump($languageId, $siteName, $targetFilePath) {
		$sqlDumpFile = Yii::getPathOfAlias('application.data.mysqlBase') . '.sql';
		$sqlDump = file_get_contents($sqlDumpFile);
		$sqlDump = $sqlDump . "\n\r" . $this->getVideoCategoriesSqlData($this->options['videoCategories'], $languageId);
		if (file_put_contents($targetFilePath, $sqlDump)) {
			return true;
		} else {
			Yii::log('Couldn\'t save changes to the database dump file "' . $sqlDumpFile . '"', 'error', 'BRemoteInstall');
		}
	}


	protected function getDatabaseName() {
		if (isset($this->databaseName)) {
			if (empty($this->databaseName) == false) {
				return $this->databaseName;
			}
		}
		$dbstring = Yii::app()->db->connectionString;
		$dbname = substr($dbstring, strpos($dbstring, 'dbname='));
		$dbname = str_replace('dbname=', '', $dbname);
		if (strpos($dbname, ';') !== false) {
			$this->databaseName = substr($dbname, 0, strpos($dbname, ';'));
		} else {
			$this->databaseName = $dbname;
		}

		return $this->databaseName;
	}

	protected function getVideoCategoriesSqlData($excludeIds, $languageId) {
		$sqlData = '';
		$sqlCondition = '';
		if (is_array($excludeIds)) {
			foreach ($excludeIds as $id) {
				$sqlCondition = $sqlCondition . ',\'' . mysql_escape_string($id) . '\'';
			}
			$sqlCondition = substr($sqlCondition, 1);
		}
		$sql = 'SELECT c.*, i.name,i.description,i.slug, i.has_i18n_image
			FROM {{video_categories}} AS c
			INNER JOIN {{video_categories_i18n}} AS i
			ON (c.cat_id=i.cat_id)
			WHERE i.language_id=:languageId';
		if (strlen($sqlCondition) > 0) {
			$sql = $sql . ' AND c.cat_id NOT IN (' . $sqlCondition . ') ';
		}
		$command = Yii::app()->db->createCommand($sql);
		$command->bindParam(':languageId', $languageId);
		$dataReader = $command->query();
		$sql = ' INSERT INTO tbl_video_categories (cat_id,
				name,
				description,
				slug,
				total_videos,
				status,
				adv,
				parent_cat_id,
				has_image)
				VALUES';
		while (($row = $dataReader->read()) !== false) {
			$hasImage = 0;
//			if ($row['has_i18n_image'] == true) {
//				$hasImage = 1;
//				copy($categoriesImagesSourceBasePath . DIRECTORY_SEPARATOR . $row['id'] . '.png', $categoriesImagesTargetBasePath . DIRECTORY_SEPARATOR . $row['cat_id'] . '.png');
//			} elseif ($row['has_image'] == true) {
			if ($row['has_image'] == true) {
				$hasImage = 1;
			}
			$sql = $sql . '(' . $row['cat_id'] . ',
					\'' . $row['name'] . '\',
					\'' . $row['description'] . '\',
					\'' . $row['slug'] . '\',
					0,
					\'1\',
					0,
					' . $row['parent_cat_id'] . ',
					' . $hasImage . '
				),';
		}
		if (substr($sql, -1, 1) == ',') {
			$sql = substr($sql, 0, strlen($sql) - 1) . ';';
		} else {//there where no categories to import so the sql will not be valid
			$sql = '';
		}
		return $sql;
	}


	public function removeDatabaseAndUser($user, $database) {
		$c = mysql_connect(Yii::app()->params['mysqlRootServer'], Yii::app()->params['mysqlRootUsername'], Yii::app()->params['mysqlRootPassword']);
		if ($c) {
			if (mysql_query('drop user \'' . mysql_real_escape_string($user) . '\'@\'localhost\';', $c)) {
				if (mysql_query('drop database if exists ' . mysql_real_escape_string($database) . ';', $c)) {
					if(mysql_query('flush privileges',$c)==false){
						Yii::log(mysql_error(), 'error', __CLASS__);
					}
					return true;
				} else {
					Yii::log(mysql_error(), 'error', __CLASS__);
					return false;
				}
			} else {
				Yii::log(mysql_error(), 'error', __CLASS__);
				return false;
			}
		} else {
			Yii::log('Could not connect to database with root account .', 'error', __CLASS__);
			return false;
		}
	}

}

?>
