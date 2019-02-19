<?php

class ExportAgsForInstallCommand extends CConsoleCommand{

	public function run($args){
		$tablesToIgnoreData=array('advertising_category',
			'advertising_template','video_categories',
			'banner_type','video','video_category','video_grabber','video_tags',
			'video_tags_lookup','user_visit','saved_search_words',
			'keywords_blacklist','managed_links');
		$sqlData='';
		$dbstring=Yii::app()->db->connectionString;
		$dbname=substr($dbstring, strpos($dbstring, 'dbname='));
		$dbname=str_replace('dbname=', '', $dbname);
		if(strpos($dbname,';')!==false){
				$dbname=substr($dbname, 0,strpos($dbname,';'));
		}
		$command='mysqldump -u \''.Yii::app()->db->username.'\' --password=\''.Yii::app()->db->password.'\' '.$dbname;
		foreach($tablesToIgnoreData as $tableToIgnore){
			$command=$command.' --ignore-table='.$dbname.'.'.Yii::app()->db->tablePrefix.$tableToIgnore;
		}
		
		$command=$command.' --add-drop-table=false --skip-comments';
		echo $command.PHP_EOL;
		$sqlData=shell_exec($command);
		$command='mysqldump -d -u \''.Yii::app()->db->username.'\' --password=\''.Yii::app()->db->password.'\'';
		$command=$command.' '.$dbname;
		foreach($tablesToIgnoreData as $tableToIgnore){
			$command=$command.' '.Yii::app()->db->tablePrefix.$tableToIgnore;
		}

		$command=$command.' --add-drop-table=false --skip-comments';
		echo $command.PHP_EOL;
		$sqlData=$sqlData."\n".shell_exec($command);
		if(file_put_contents(Yii::getPathOfAlias('application.data.mysqlBase').'.sql', $sqlData)==false){
			echo 'Failed saving mysql dump to '.Yii::getPathOfAlias('application.data.mysqlBase').'.sql'.PHP_EOL;
		}
		$agsSourcePath=dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR;
		$agsExportPath=$agsSourcePath.'..'.DIRECTORY_SEPARATOR.'masterControl'.DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'ags'.DIRECTORY_SEPARATOR.'deflated'.DIRECTORY_SEPARATOR;
		exec('rm -rf '.$agsExportPath);
		exec('rsync -aC '.$agsSourcePath.' '.$agsExportPath);
//		exec('find '.$agsExportPath.' -name ".svn" -type d -exec rm -rf {} \;');
		exec('rm '.$agsExportPath.DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'mysql.sql');
		exec('rm -rf '.$agsExportPath.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'videos'.DIRECTORY_SEPARATOR.'tmb'.DIRECTORY_SEPARATOR.'*');
		exec('rm -rf '.$agsExportPath.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'*');
		exec('rm -rf '.$agsExportPath.DIRECTORY_SEPARATOR.'nbproject'.DIRECTORY_SEPARATOR);
		exec('rm -rf '.$agsExportPath.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'categories'.DIRECTORY_SEPARATOR.'*');
		exec('rm -rf '.$agsExportPath.DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'runtime'.DIRECTORY_SEPARATOR.'application.log.*');
		exec('rm -rf '.$agsExportPath.DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'runtime'.DIRECTORY_SEPARATOR.'smarty'.DIRECTORY_SEPARATOR.'compiled'.DIRECTORY_SEPARATOR.'*');
		//clean upgrade backup data
		exec('rm -f '.$agsExportPath.'protected'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'backup'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'*');
		exec('rm -f '.$agsExportPath.'protected'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'backup'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'custom'.DIRECTORY_SEPARATOR.'*');
		exec('rm -f '.$agsExportPath.'protected'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'backup'.DIRECTORY_SEPARATOR.'sql'.DIRECTORY_SEPARATOR.'*');
//		echo PHP_EOL.PHP_EOL;
//		echo 'rm -f '.$agsExportPath.'protected'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'backup'.DIRECTORY_SEPARATOR.'sql'.DIRECTORY_SEPARATOR.'*'.PHP_EOL;
		
		exec('rm -f '.$agsExportPath.'protected'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'toEditByUpgradeScript'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'*');
		exec('rm -f '.$agsExportPath.'protected'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'toEditByUpgradeScript'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'custom'.DIRECTORY_SEPARATOR.'*');
		exec('rm -f '.$agsExportPath.'protected'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'toEditByUpgradeScript'.DIRECTORY_SEPARATOR.'sql'.DIRECTORY_SEPARATOR.'*');

		
		$indexContent=file_get_contents($agsExportPath.'index.php');
		if($indexContent!=false){
			$indexContent=str_replace('$yii=dirname(__FILE__).\'/../framework/yii.php\';','$yii=dirname(__FILE__).\'/framework/yii.php\';' , $indexContent);
			$indexContent=str_replace('// remove the following lines when in production mode','' , $indexContent);
			$indexContent=str_replace("defined('YII_DEBUG') or define('YII_DEBUG',true);",'' , $indexContent);
			$indexContent=str_replace("// specify how many levels of call stack should be shown in each log message",'' , $indexContent);
			$indexContent=str_replace("defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);",'' , $indexContent);
			
			file_put_contents($agsExportPath.'index.php', $indexContent);
		}else{
			echo 'Error changing index.php file '.PHP_EOL;
		}

		
		exec('chmod 0666 '.$agsExportPath.'protected'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'custom'.DIRECTORY_SEPARATOR.'*');
		exec('chmod 0777 '.$agsExportPath.'protected'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR);
		changePermissionForFile($agsExportPath.'protected'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'urls.php');
		changePermissionForFile($agsExportPath.'protected'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'main.php');
		changePermissionForFile($agsExportPath.'protected'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'developerDb.php');
		changePermissionForFile($agsExportPath.'themes'.DIRECTORY_SEPARATOR.'webAnalyticsJsCode');
		if(is_dir($agsExportPath.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'categories')==false){
			chmod($agsExportPath.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'categories', 0777);
			echo 'rm -rf '.$agsExportPath.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'categories/*'.PHP_EOL;
		}
		if(is_dir($agsExportPath.DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'runtime'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR)==false){
			mkdir($agsExportPath.DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'runtime'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR);
		}
		chmod($agsExportPath.DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'runtime'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR, 0777);
		if(is_file($agsExportPath.DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'commands'.DIRECTORY_SEPARATOR.'ExportAgsForInstallCommand.php')==true){
			unlink($agsExportPath.DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'commands'.DIRECTORY_SEPARATOR.'ExportAgsForInstallCommand.php');
		}
		if(is_file($agsExportPath.DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'.svn_externals_extensions.txt')==true){
			unlink($agsExportPath.DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'.svn_externals_extensions.txt');
		}
		if(is_file($agsExportPath.DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'.svn_externals_modules.txt')==true){
			unlink($agsExportPath.DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'.svn_externals_modules.txt');
		}
		if(is_file($agsExportPath.DIRECTORY_SEPARATOR.'rsync_command.txt')==true){
			unlink($agsExportPath.DIRECTORY_SEPARATOR.'rsync_command.txt');
		}
		if(is_file($agsExportPath.DIRECTORY_SEPARATOR.'rsync_exclude.txt')==true){
			unlink($agsExportPath.DIRECTORY_SEPARATOR.'rsync_exclude.txt');
		}

		exec('cp '.$agsExportPath.DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'main.php '.$agsExportPath.DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'main.original.php');
		exec('cp '.$agsExportPath.DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'urls.php '.$agsExportPath.DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'urls.original.php');
		exec('cp '.$agsExportPath.DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'custom'.DIRECTORY_SEPARATOR.'unifiedConfiguration.php '.$agsExportPath.DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'custom'.DIRECTORY_SEPARATOR.'unifiedConfiguration.original.php');
		$configuration=require_once($agsExportPath.DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'custom'.DIRECTORY_SEPARATOR.'unifiedConfiguration.original.php');
/**
  'defaultPageTitle' => 'default page title',
  'defaultDescription' => 'default description',
  'defaultKeywords' => 'default keywords',
  'tagPageTitle' => 'tag page title| {title}',
  'tagDescription' => 'tag description| {description}',
  'tagKeywords' => 'tag keywords | {keywords}',
  'searchPageTitle' => 'search page title {title} {description} {keywords}',
  'searchDescription' => 'search description {title} {description} {keywords}',
  'searchKeywords' => 'search keywords {title} {description} {keywords}',
  'videoViewPageTitle' => 'video view page title {title} {description} {keywords}',
  'videoViewDescription' => 'video view page description {title} {description} {keywords}',
  'videoViewKeywords' => 'video view page keywords {title} {description} {keywords}',
  'videoCategoryPageTitle' => 'videoCategoryPageTitle - {title} ',
  'videoCategoryDescription' => 'video category paget description {title} {description} {keywords}',
  'videoCategoryKeywords' => 'video category keywords {title} {description} {keywords}',

 */
		$configuration['defaultPageTitle']='';
		$configuration['defaultDescription']='';
		$configuration['defaultKeywords']='';
		$configuration['tagPageTitle']='';
		$configuration['tagDescription']='';
		$configuration['tagKeywords']='';
		$configuration['searchPageTitle']='';
		$configuration['searchDescription']='';
		$configuration['searchKeywords']='';
		$configuration['videoViewPageTitle']='';
		$configuration['videoViewDescription']='';
		$configuration['videoViewKeywords']='';
		$configuration['videoCategoryPageTitle']='';
		$configuration['videoCategoryDescription']='';
		$configuration['videoCategoryKeywords']='';
		file_put_contents($agsExportPath.DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'custom'.DIRECTORY_SEPARATOR.'unifiedConfiguration.original.php', var_export($configuration,true));
		echo PHP_EOL.' Trebuie verificat daca in fisierul unifiedConfiguration.original.php valorile la meta taguri sunt goale '.PHP_EOL;
//		exec('cp -R '.$agsSourcePath.'protected'.DIRECTORY_SEPARATOR.'config '.$agsExportPath.DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'config');
//		exec('cp -R '.$agsSourcePath.'protected'.DIRECTORY_SEPARATOR.'data '.$agsExportPath.DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'data');
	}
}
function changePermissionForFile($file,$permission=0666){
	if(is_file($file)==true){
		chmod($file, $permission);
	}else{
		echo 'The file '.$file.' does not exist'.PHP_EOL;
	}

}
?>
