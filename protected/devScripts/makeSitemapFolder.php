<?php

$basePath = '/home/sites/agsi/protected/config/';
$handle = opendir($basePath);


if ($handle) {
	while (false !== ($entry = readdir($handle))) {
		if ($entry != '.' && $entry != '..' and $entry != '.maildir' and is_dir($basePath . $entry) == true
				and $entry != 'sites1.bigbang-1.com' and $entry != 'sites2.bigbang-1.com' and $entry != 'global' and $entry != 'original') {
			
			$dir='/home/sites/agsi/sitemaps/'.$entry;
			if(is_dir($dir)==false){
				if(mkdir($dir)==false){
					echo 'nu am reusit sa fac '.$dir.  PHP_EOL;
				}else{
					echo 'am facut '.$dir.  PHP_EOL;
				}
			}

		}
	}
	closedir($handle);
}
?>
