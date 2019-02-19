<?php

$basePath = '/home/sites/agsi/protected/config/';
$handle = opendir($basePath);


if ($handle) {
	while (false !== ($entry = readdir($handle))) {
		if ($entry != '.' && $entry != '..' and $entry != '.maildir' and is_dir($basePath . $entry) == true
				and $entry != 'sites1.bigbang-1.com' and $entry != 'global') {
			echo $entry . PHP_EOL;
			if (is_file($basePath . $entry . '/applicationDb.php')) {
				$config = require($basePath . $entry . '/applicationDb.php');
				unset($config['pdoClass']);
				$config['class']='CDbConnection';
				if(file_put_contents($basePath . $entry . '/applicationDb.php', '<?php return '.var_export($config,true).'; ?>')==false){
					echo 'could not write to file file "' . $basePath . $entry . '/applicationDb.php' . '"' . PHP_EOL;
				}
				
			} else {
				echo 'could not find file "' . $basePath . $entry . '/applicationDb.php' . '"' . PHP_EOL;
			}


		}
	}
	closedir($handle);
}
?>
