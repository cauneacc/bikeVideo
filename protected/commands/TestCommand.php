<?php

class TestCommand extends CConsoleCommand{

	public function run($args){
//		echo __FILE__ . ' ' . __LINE__ . '<pre>' . PHP_EOL;
//		var_dump(Yii::app()->db);
//		echo '</pre>' . PHP_EOL;
		echo 'testul a reusit'.  PHP_EOL;
		exit;
		$_SERVER['REMOTE_ADDR']='127.0.0.1';
		Yii::import('application.modules.api.libraries.remoteInstall.AgsiPinklionApi');
		$api=new AgsiPinklionApi();
		$siteName='agsa.com';
//		$r=$api->createHosting($siteName, '127.0.0.1');
//		echo __FILE__ . ' ' . __LINE__ . '<pre>' . PHP_EOL;
//		var_dump($r);
//		echo '</pre>' . PHP_EOL;
//		exit;
//		$r=$api->getHostingInformation($siteName);
//		echo __FILE__ . ' ' . __LINE__ . '<pre>' . PHP_EOL;
//		var_dump($r);
//		echo '</pre>' . PHP_EOL;
//		exit;
//		$r=$api->modifyHostingIp($siteName, '127.0.0.1');
//		echo __FILE__ . ' ' . __LINE__ . '<pre>' . PHP_EOL;
//		var_dump($r);
//		echo '</pre>' . PHP_EOL;
//		exit;

		$r=$api->deleteHosting($siteName);
		echo __FILE__ . ' ' . __LINE__ . '<pre>' . PHP_EOL;
		var_dump($r);
		echo '</pre>' . PHP_EOL;
		exit;

	}

}
?>
