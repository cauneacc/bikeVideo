<?php

/**
 * This is the model class for table "cms2_galleries".
 *
 * The followings are the available columns in table 'cms2_galleries':
 * @property integer $id
 * @property string $name
 * @property string $desc
 */
class Cms2Galleries extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Cms2Galleries the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cms2_galleries';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, desc', 'required'),
            array('name', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, desc', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        'cms2Images'=>array(self::MANY_MANY, 'Cms2Images',
                'cms2_galleries_images(gallery_id,image_id)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'desc' => 'Desc',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('desc', $this->desc, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function afterSave(){
        parent::afterSave();
        if(isset($_REQUEST['Cms2Image'])){
            if(is_array($_REQUEST['Cms2Image'])){
				$_REQUEST['Cms2Image']=array_unique($_REQUEST['Cms2Image']);
                Cms2GalleriesImages::model()->deleteAll();
                $images=array_unique($_REQUEST['Cms2Image']);
                foreach($images as $imageId){
                    
                    $dbImage=Cms2Images::model()->findByPk($imageId);
                    if(Cms2Images::model()->count('id=:id',array(':id'=>$imageId))==1){
                        $galleryImage=new Cms2GalleriesImages();
                        $galleryImage->gallery_id=$this->id;
                        $galleryImage->image_id=$imageId;
                        $galleryImage->save();
                    }
                }
            }
            
        }
        return true;
    }
}