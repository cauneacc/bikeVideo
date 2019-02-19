<?php

/**
 * This is the model class for table "cms2_articles".
 *
 * The followings are the available columns in table 'cms2_articles':
 * @property integer $id
 * @property string $name
 * @property string $desc
 * @property string $add_date
 * @property integer $status
 * @property integer $category_id
 * @property integer $image_slug
 */
class Cms2Articles extends CActiveRecord{

	/**
	 * Returns the static model of the specified AR class.
	 * @return Cms2Articles the static model class
	 */
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName(){
		return 'cms2_articles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules(){
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, desc, status, category_id, tease', 'required'),
			array('status, category_id, gallery_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, desc, add_date, status, category_id, slug, image_slug', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations(){
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'VideoCategories'=>array(self::HAS_ONE, 'VideoCategories', '', 'on'=>'t.category_id=VideoCategories.cat_id'),
			'Cms2Images'=>array(self::HAS_ONE, 'Cms2Images', '', 'on'=>'t.image_slug=Cms2Images.slug'),
			'Cms2Galleries'=>array(self::HAS_ONE, 'Cms2Galleries', '', 'on'=>'t.gallery_id=Cms2Galleries.id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels(){
		return array(
			'id'=>'ID',
			'name'=>'Name',
			'desc'=>'Desc',
			'add_date'=>'Add Date',
			'status'=>'Status',
			'category_id'=>'Category',
			'image_slug'=>'Image',
			'tease'=>'Tease',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search(){
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('desc', $this->desc, true);
		$criteria->compare('add_date', $this->add_date, true);
		$criteria->compare('status', $this->status);
		$criteria->compare('category_id', $this->category_id);
		$criteria->compare('image_slug', $this->image_slug);
		$criteria->compare('slug', $this->slug);
		$criteria->with=array('VideoCategories');
		$a=new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
		return $a;
	}
	
	public function beforeSave() {
		parent::beforeSave();
		Yii::import('application.lib.AGSStringHelper');
		$stringHelper = new AGSStringHelper();
		$this->slug = $stringHelper->prepare_string($this->name, true);
		return true;
	}

}