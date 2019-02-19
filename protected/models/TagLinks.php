<?php

class TagLinks extends CActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{tag_links}}';
	}


}
?>