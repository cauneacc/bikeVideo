<?php
class Upgrade{
	static function backupData(){
		$return=true;
		$dbstring=Yii::app()->db->connectionString;
		$dbname=substr($dbstring, strpos($dbstring, 'dbname='));
		$dbname=str_replace('dbname=', '', $dbname);
		if(strpos($dbname,';')!==false){
				$dbname=substr($dbname, 0,strpos($dbname,';'));
		}
		$basePath=Yii::getPathOfAlias('application');

		$mysqlDumpCommand='mysqldump -u \''.Yii::app()->db->username.'\' --password=\''.Yii::app()->db->password.'\'';
		$sql='show tables';
		$command=Yii::app()->db->createCommand($sql);
		$tables=$command->queryAll();
		if(is_array($tables)){
			foreach($tables as $table){
				if(isset($table['Tables_in_'.$dbname])){
					$shellCommand=$mysqlDumpCommand.' --no-data --add-drop-table=false --skip-comments ';
					$shellCommand=$shellCommand.$dbname.' '.$table['Tables_in_'.$dbname].' > ';
					$shellCommand=$shellCommand.$basePath.'/data/backup/sql/'.$table['Tables_in_'.$dbname].'-structure.sql';
//					echo $shellCommand.PHP_EOL;
					shell_exec($shellCommand);
					$shellCommand=$mysqlDumpCommand.' --no-create-info --add-drop-table=false --skip-comments ';
					$shellCommand=$shellCommand.$dbname.' '.$table['Tables_in_'.$dbname].' > ';
					$shellCommand=$shellCommand.$basePath.'/data/backup/sql/'.$table['Tables_in_'.$dbname].'-data.sql';
//					echo $shellCommand.PHP_EOL;
					shell_exec($shellCommand);
					shell_exec('cp '.$basePath.'/data/backup/sql/'.$table['Tables_in_'.$dbname].'-data.sql '.$basePath.'/data/toEditByUpgradeScript/sql/'.$table['Tables_in_'.$dbname].'-data.sql');
					shell_exec('cp '.$basePath.'/data/backup/sql/'.$table['Tables_in_'.$dbname].'-structure.sql '.$basePath.'/data/toEditByUpgradeScript/sql/'.$table['Tables_in_'.$dbname].'-structure.sql');
				}else{
					echo 'Could not get table name'.PHP_EOL;
				}
			}
		}else{
			$return=false;
		}
		shell_exec('cp '.$basePath.'/config/* '.$basePath.'/data/backup/config/');
		shell_exec('cp '.$basePath.'/config/custom/unifiedConfiguration.php '.$basePath.'/data/backup/config/custom/unifiedConfiguration.php');
		shell_exec('cp '.$basePath.'/config/* '.$basePath.'/data/toEditByUpgradeScript/config/');
		shell_exec('cp '.$basePath.'/config/custom/unifiedConfiguration.php '.$basePath.'/data/toEditByUpgradeScript/config/custom/unifiedConfiguration.php');
		return $return;
	}
}
?>
