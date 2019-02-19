<?php
if (isset($argv[$argc-1])) {
	if (substr($argv[$argc-1], 0, 9) == '--config=') {
		$site = trim(substr($argv[$argc-1], 9), '/');
		if (is_file(dirname(__FILE__) . '/config/' . $site . '/console.php')) {
			$yiic = dirname(__FILE__) . '/framework/yiic.php';
			$config = dirname(__FILE__) . '/config/' . $site . '/console.php';
			unset($argv[$argc-1]);
			$argc = $argc - 1;
			require_once($yiic);
		} else {
			echo 'Could not find the configuration file for site "' . $site . '"' . PHP_EOL;
			exit;
		}
	} else {
		echo 'The --config=site configuration is missing. Choose a site on which to apply this command' . PHP_EOL;
		exit;
	}
} else {
	echo 'The --config=site configuration is missing. Choose a site on which to apply this command' . PHP_EOL;
	exit;
}


