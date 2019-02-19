<?php

$basePath = '/home/sites/agsi/protected/config/';
$handle = opendir($basePath);


if ($handle) {
	while (false !== ($entry = readdir($handle))) {
		if ($entry != '.' && $entry != '..' and $entry != '.maildir' and is_dir($basePath . $entry) == true
				and $entry != 'sites1.bigbang-1.com' and $entry != 'global' and $entry != 'original' and $entry != 'agsi'
				 and $entry != 'sites2.bigbang-1.com') {
			echo $entry . PHP_EOL;
			if (is_file($basePath . $entry . '/applicationDb.php')) {
				$config = require($basePath . $entry . '/applicationDb.php');
				$dbConn = mysql_connect('localhost', $config['username'], $config['password']);
				if ($dbConn) {
					if (mysql_select_db($config['username'], $dbConn)) {
						$sql = "update `tbl_video_categories` set name='Grosse bite',slug='grosse-bite' where slug='brosse-bite' ";
						if (mysql_query($sql, $dbConn)) {
								echo 'success' . PHP_EOL;
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
				echo 'could not find file "' . $basePath . $entry . '/applicationDb.php' . '"' . PHP_EOL;
			}

		}
	}
	closedir($handle);
}
?>
