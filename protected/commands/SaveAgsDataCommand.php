<?php

class SaveAgsDataCommand extends CConsoleCommand{

	public function run($args){
		Yii::import('application.lib.Upgrade');
		Upgrade::backupData();
	}

}
?>
