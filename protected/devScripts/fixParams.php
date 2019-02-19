<?php

//$baseDir = '/home/claudiu/Munca/php/agsi/protected/config/';
$baseDir='/home/sites/agsi/protected/config/';
$handle = opendir($baseDir);
if ($handle) {
	while (false !== ($entry = readdir($handle))) {
		if ($entry != '.' && $entry != '..' and is_dir($baseDir . $entry) == true and $entry != 'agsi' and $entry != 'original' and $entry != 'global'
				and $entry != 'sites1.bigbang-1.com' and $entry != 'sites2.bigbang-1.com' ) {
			if (is_file($baseDir . $entry . '/params.php')) {
				$config = require($baseDir . $entry . '/params.php');
				$config['masterControlRootUrl']='http://static.'.$entry;
				if(file_put_contents($baseDir . $entry . '/params.php', '<?php return '.var_export($config,true).'; ?>')==false){
					echo 'could not write to file file "' . $baseDir . $entry . '/params.php' . '"' . PHP_EOL;
				}
				
			} else {
				echo 'could not find file "' . $baseDir . $entry . '/params.php' . '"' . PHP_EOL;
			}


		}
	}
	closedir($handle);
}
?>
