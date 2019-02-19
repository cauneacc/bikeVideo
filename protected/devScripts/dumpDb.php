<?php
$config=require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'main.php');
$config['db']['connectionString'];
$config['db']['username'];
$config['db']['password'];
$dbstring=$config['components']['db']['connectionString'];
$dbname=substr($dbstring, strpos($dbstring,'dbname='));
$dbname=str_replace('dbname=', '', $dbname);
$file=realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'mysql.sql';
$command='mysqldump -u '.$config['components']['db']['username'].' -p '.$dbname.' --no-data=true --add-drop-table=true --skip-comments -r '.$file;

echo $command.PHP_EOL;
exec(escapeshellcmd($command));