<?php

//$baseDir = '/home/claudiu/Munca/php/agsi/protected/config/';
$baseDir='/home/sites/agsi/protected/config/';
$handle = opendir($baseDir);
if ($handle) {
	while (false !== ($entry = readdir($handle))) {
		if ($entry != '.' && $entry != '..' and is_dir($baseDir . $entry) == true and $entry != 'agsi' and $entry != 'global') {

			echo $entry . PHP_EOL;
			$text=file_get_contents($baseDir  . $entry . '/main.php');
			if ($text) {
				
				$search=array("'dbRoot'=>require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'rootDb.php') ,","'dbRoot'=>require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'rootDb.php'),","'dbRoot'=>
			require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'rootDb.php') ,");
				$replace='';
				$text=  str_replace($search, $replace, $text);
				if(file_put_contents($baseDir  . $entry . '/main.php',$text)==false){
					echo 'nu am reusit sa scriu fisierul '.$baseDir  . $entry . '/main.php'.PHP_EOL;
				}
			} else {
				echo 'se pare ca nu e instalat ags pentru site-ul  "' . $entry . '"' . PHP_EOL;
			}
			
			$text=file_get_contents($baseDir  . $entry . '/console.php');
			if($text){
				$search=array("'dbRoot'=>require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'rootDb.php') ,","'dbRoot'=>require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'rootDb.php'),","'dbRoot'=>
			require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'rootDb.php') ,");
				$replace='';
				$text=  str_replace($search, $replace, $text);
				if(file_put_contents($baseDir  . $entry . '/console.php',$text)==false){
					echo 'nu am reusit sa scriu fisierul '.$baseDir  . $entry . '/console.php'.PHP_EOL;
				}
				
			}else {
				echo 'nu am reusit sa citesc fisierul '.$baseDir  . $entry . '/console.php' . PHP_EOL;
			}
		}
	}
	closedir($handle);
}
?>
