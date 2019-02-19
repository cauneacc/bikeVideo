<?php

/**
 * This is the model class for table "cms2_images".
 *
 * The followings are the available columns in table 'cms2_images':
 * @property integer $id
 * @property string $add_date
 * @property string $name
 * @property string $description
 */
class Cms2Images extends CActiveRecord {

	public $imageUploadName = 'file';

	/**
	 * Returns the static model of the specified AR class.
	 * @return Cms2Images the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public static function createSmallImageUrl(&$model) {
		return Yii::app()->baseUrl . '/images/cms2/images/' . $model->slug . '-s.png';
	}

	public static function createMediumImageUrl(&$model) {
		return Yii::app()->baseUrl . '/images/cms2/images/' . $model->slug . '-m.png';
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'cms2_images';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description', 'required'),
			array('name', 'length', 'max' => 255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, add_date, name, description,slug', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'add_date' => 'Add Date',
			'name' => 'Name',
			'description' => 'Description',
			'slug' => 'Slug',
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
		$criteria->compare('add_date', $this->add_date, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('description', $this->description, true);
		$criteria->compare('slug', $this->slug, true);

		return new CActiveDataProvider($this, array(
					'criteria' => $criteria,
			'pagination'=>array(
        'pageSize'=>2,
    ),
				));
	}

	public function beforeSave() {
		parent::beforeSave();
		Yii::import('application.lib.AGSStringHelper');
		$stringHelper = new AGSStringHelper();
		$this->slug = $stringHelper->prepare_string($this->name, true) . '-' . rand(0, 9999);

		return true;
	}

	public function afterSave() {
		parent::afterSave();
		if ($_FILES[$this->imageUploadName]['name']) {
			$info = pathinfo($_FILES[$this->imageUploadName]['name']);
			if (empty($info['extension']) == false) {
				$tmpImagePath = Yii::getPathOfAlias('application.runtime.cms2.images.' . $this->id . '-' . rand(0, 9999)) . '.' . $info['extension'];
				$partialImagePath = Yii::getPathOfAlias('webroot.images.cms2.images.' . $this->slug);
				if (move_uploaded_file($_FILES[$this->imageUploadName]['tmp_name'], $tmpImagePath)) {
					$image = Yii::app()->image->load($tmpImagePath);
					if (!$image) {
						unlink($tmpImagePath);
						return false;
					} else {
						$image->resize(1024, 768);
						$image->save($partialImagePath . '-m.png');
						$image->resize(200, 150);
						$image->save($partialImagePath . '-s.png');
						unlink($tmpImagePath);
					}
				}
			}
		}
	}
	
	public function beforeDelete() {
		$partialImagePath = Yii::getPathOfAlias('webroot.images.cms2.images.' . $this->slug);
		if(is_file($partialImagePath . '-m.png')){
			unlink($partialImagePath . '-m.png');
		}
		if(is_file($partialImagePath . '-s.png')){
			unlink($partialImagePath . '-s.png');
		}
		Cms2GalleriesImages::model()->deleteAll('image_id=:imageId',array(':imageId'=>$this->id));
		$articles=Cms2Articles::model()->findAll('slug=:slug',array(':slug'=>$this->slug));
		foreach($articles as $article){
			$article->image_slug=null;
			$article->save();
		}
		parent::beforeDelete();
		return true;
	}

}