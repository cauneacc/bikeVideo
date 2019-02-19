<?php

class UpgradeController extends Controller{

	public function actionPrepareForUpgrade(){
		Yii::import('application.lib.Upgrade');
		echo serialize(Upgrade::backupData());
	}
	
}

?>
