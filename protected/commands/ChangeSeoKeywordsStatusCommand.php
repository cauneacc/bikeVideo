<?php

class ChangeSeoKeywordsStatusCommand extends CConsoleCommand{

	public function run($args){
		$keywords=SeoKeywordsPage::model()->findAll('status=0 order by id asc limit :limit ',array(':limit'=>Yii::app()->params['seoKeywordsToActivateDaily']));
		foreach($keywords as $keyword){
			$keyword->status=1;
			$keyword->save();
		}
		
	}
}

?>
