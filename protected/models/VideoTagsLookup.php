<?php
class VideoTagsLookup extends CActiveRecord{
    public static function model($className=__CLASS__){
        return parent::model($className);
    }

    public function tableName(){
        return '{{video_tags_lookup}}';
    }
    
}