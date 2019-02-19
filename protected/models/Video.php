<?php

/**
 * This is the model class for table "{{video}}".
 *
 * The followings are the available columns in table '{{video}}':
 * @property string $video_id
 * @property string $user_id
 * @property string $title
 * @property string $description
 * @property double $rating
 * @property string $rated_by
 * @property double $duration
 * @property integer $thumb
 * @property integer $thumbs
 * @property string $embed_code
 * @property string $allow_embed
 * @property string $allow_rating
 * @property string $allow_comment
 * @property string $allow_download
 * @property string $total_views
 * @property string $total_comments
 * @property string $total_downloads
 * @property string $total_favorites
 * @property string $type
 * @property string $ext
 * @property integer $size
 * @property string $add_date
 * @property string $view_date
 * @property integer $server
 * @property string $sponsor
 * @property string $flagged
 * @property string $locked
 * @property integer $status
 * @property string $adv
 * @property string $url
 * @property string $premium
 * @property double $price
 * @property string $slug
 * @property string $add_time
 * @property string $thumb_url
 * @property string $sponsor_page
 * @property string $rated_up
 * @property string $rated_down
 * @property string $publish_time
 * @property string $custom_fields
 */
class Video extends CActiveRecord {

	public $categories = null;
	public $synonyms = null;
	public $stringHelper = null;
	public $imageWorker = null;
	public $videoWorker = null;
	public $category = null;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Video the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{video}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
//			array('user_id','checkUserExists','allowEmpty'=>false,'attributeName'=>'id','className'=>'YumUser'),
//			array('description, publish_time, total_comments, total_downloads, total_favorites', 'required'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'videoCategories' => array(self::MANY_MANY, 'VideoCategories',
				'tbl_video_category(video_id, cat_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'video_id' => 'Video',
			'user_id' => 'User',
			'title' => 'Title',
			'description' => 'Description',
			'rating' => 'Rating',
			'rated_by' => 'Rated By',
			'duration' => 'Duration',
			'thumb' => 'Thumb',
			'thumbs' => 'Thumbs',
			'embed_code' => 'Embed Code',
			'allow_embed' => 'Allow Embed',
			'allow_rating' => 'Allow Rating',
			'allow_comment' => 'Allow Comment',
			'allow_download' => 'Allow Download',
			'total_views' => 'Total Views',
			'total_comments' => 'Total Comments',
			'total_downloads' => 'Total Downloads',
			'total_favorites' => 'Total Favorites',
			'type' => 'Type',
			'ext' => 'Ext',
			'size' => 'Size',
			'add_date' => 'Add Date',
			'view_date' => 'View Date',
			'server' => 'Server',
			'sponsor' => 'Sponsor',
			'flagged' => 'Flagged',
			'locked' => 'Locked',
			'status' => 'Status',
			'adv' => 'Adv',
			'url' => 'Url',
			'premium' => 'Premium',
			'price' => 'Price',
			'slug' => 'Slug',
			'add_time' => 'Add Time',
			'thumb_url' => 'Thumb Url',
			'sponsor_page' => 'Sponsor Page',
			'rated_up' => 'Rated Up',
			'rated_down' => 'Rated Down',
			'publish_time' => 'Publish Time',
			'custom_fields' => 'Custom Fields',
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

		$criteria->compare('video_id', $this->video_id, true);
		$criteria->compare('user_id', $this->user_id, true);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('description', $this->description, true);
		$criteria->compare('rating', $this->rating);
		$criteria->compare('rated_by', $this->rated_by, true);
		$criteria->compare('duration', $this->duration);
		$criteria->compare('thumb', $this->thumb);
		$criteria->compare('thumbs', $this->thumbs);
		$criteria->compare('embed_code', $this->embed_code, true);
		$criteria->compare('allow_embed', $this->allow_embed, true);
		$criteria->compare('allow_rating', $this->allow_rating, true);
		$criteria->compare('allow_comment', $this->allow_comment, true);
		$criteria->compare('allow_download', $this->allow_download, true);
		$criteria->compare('total_views', $this->total_views, true);
		$criteria->compare('total_comments', $this->total_comments, true);
		$criteria->compare('total_downloads', $this->total_downloads, true);
		$criteria->compare('total_favorites', $this->total_favorites, true);
		$criteria->compare('type', $this->type, true);
		$criteria->compare('ext', $this->ext, true);
		$criteria->compare('size', $this->size);
		$criteria->compare('add_date', $this->add_date, true);
		$criteria->compare('view_date', $this->view_date, true);
		$criteria->compare('server', $this->server);
		$criteria->compare('sponsor', $this->sponsor, true);
		$criteria->compare('flagged', $this->flagged, true);
		$criteria->compare('locked', $this->locked, true);
		$criteria->compare('status', $this->status);
		$criteria->compare('adv', $this->adv, true);
		$criteria->compare('url', $this->url, true);
		$criteria->compare('premium', $this->premium, true);
		$criteria->compare('price', $this->price);
		$criteria->compare('slug', $this->slug, true);
		$criteria->compare('add_time', $this->add_time, true);
		$criteria->compare('thumb_url', $this->thumb_url, true);
		$criteria->compare('sponsor_page', $this->sponsor_page, true);
		$criteria->compare('rated_up', $this->rated_up, true);
		$criteria->compare('rated_down', $this->rated_down, true);
		$criteria->compare('publish_time', $this->publish_time, true);
		$criteria->compare('custom_fields', $this->custom_fields, true);

		return new CActiveDataProvider(get_class($this), array(
					'criteria' => $criteria,
				));
	}

	/**
	 *
	 * @param array $data - an array containing all the data needed to create
	 * a new video
	 * @return boolean
	 */
	public function add_video($video, $automaticChangeTitle = true) {
		Yii::import('ext.crawlers.libraries.BCurl');
		if ($this->categories == null) {
			$this->categories = VideoCategories::model()->findAll(array('condition' => 'status=\'1\''));
		}
		if ($this->synonyms == null) {
			Yii::import('ext.synonims.BSynonims');
			$this->synonyms = new BSynonims();
		}
		if ($this->stringHelper == null) {
			Yii::import('application.lib.AGSStringHelper');
			$this->stringHelper = new AGSStringHelper();
		}
		if ($this->imageWorker == null) {
			$this->imageWorker = new BImage();
		}
		if ($this->videoWorker == null) {
			Yii::import('ext.file.AGSVideoWorker');
			$this->videoWorker = new AGSVideoWorker();
		}

		$this->manageMessages('Adding video {videoUrl} ... ', array('{videoUrl}' => $video['url']));
		$video['title'] = str_replace('&amp;#039;', '\'', $video['title']);
		$video['title'] = str_replace('&amp;amp;', '&', $video['title']);
		$video['title'] = str_replace('&amp;', '&', $video['title']);
		$video['title'] = str_replace('#039;', '\'', $video['title']);
		$video['title'] = html_entity_decode($video['title'], ENT_NOQUOTES, 'UTF-8');


		if (isset($video['categories'])) {
			if (is_array($video['categories'])) {
				$categories = $video['categories'];
				unset($video['categories']);
			}
			unset($video['categories']);
		} else {
			$categories = array($this->match_category($video['category'], $video['title'], $video['desc'], $video['tags']));
		}
		$videoModel = new Video();
		$videoModel->user_id = $this->user_id;
		if ($automaticChangeTitle == true) {
			$videoModel->title = $this->synonyms->changeTitle($video['title']);
		} else {
			$videoModel->title = $video['title'];
		}
		$videoModel->slug = $this->stringHelper->prepare_string($videoModel->title, TRUE);
		$videoModel->description = html_entity_decode($video['desc'], ENT_NOQUOTES, 'UTF-8');
		$videoModel->type = 'public';
		$videoModel->add_date = date('Y-m-d h:i:s');
		$videoModel->add_time = time();
		$videoModel->status = 5;
		$videoModel->user_id = Yii::app()->params['defaultUserId'];
		$videoModel->embed_code = $video['embed'];
		$videoModel->url = $video['url'];
		$videoModel->video_source = 0;

		if ($videoModel->save()) {
			$videoAcquired = true;
			if (empty($videoModel->url) == false and $video['downloadVideoFile'] == true) {
				$videoAcquired = $this->videoWorker->downloadFlv($videoModel->url, $videoModel->video_id);
			}
			if ($videoAcquired == true) {
//					$videoGrabberModel = new VideoGrabber();
//					$videoGrabberModel->video_id = $videoModel->video_id;
//					$videoGrabberModel->site = $video['site'];
//					$videoGrabberModel->url = $video['url'];
//					$videoGrabberModel->save();
				$this->addCategoriesToNewVideo($categories, $videoModel);
				$this->insertTags($video['tags'], $videoModel->video_id);
				if (isset($video['thumbs'])) {
					$thumbDir = $this->imageWorker->chooseVideoThumbnailDirectory($videoModel->video_id);
					if ($this->imageWorker->createFolderStructure($thumbDir) == true) {
						$count = 1;
						$valid = 0;
						$i = 0;
						$max = count($video['thumbs']);
						while ($i < $max and $i < Yii::app()->params['numberOfThumbsToExtract']) {
							$tmb_path = $thumbDir . DIRECTORY_SEPARATOR . $count . '.jpg';
							$this->manageMessages('saving thumb to {thumbPath}', array('{thumbPath' => $tmb_path), 'info');
							if (BCurl::file($video['thumbs'][$i], $tmb_path)) {
								if (Yii::app()->params['videoThumbWidth'] > 0 and Yii::app()->params['videoThumbHeight'] > 0) {
									sleep(1);
									clearstatcache();

									if (filesize($tmb_path) > 1000) {
										$image = Yii::app()->image->load($tmb_path);
										if (!$image) {
											unlink($tmb_path);
											$processed = FALSE;
											$this->manageMessages('error processing image {thumbUrl}', array('{thumbUrl' => $video['thumbs'][$i]), 'error');
										} else {
											$image->resize(Yii::app()->params['videoThumbWidth'], Yii::app()->params['videoThumbHeight']);
											$a = $image->save();
											if (file_exists($tmb_path) == true) {
												if (filesize($tmb_path) > 3) {
													$processed = true;
												} else {
													unlink($tmb_path);
													$processed = false;
												}
											} else {
												$processed = false;
											}
										}
									} else {
										$processed = false;
									}
								}
								if ($processed === TRUE) {
									$this->manageMessages('DONE', null, 'info');
									++$valid;
									++$count;
								}
							} else {
								$this->manageMessages('FAILED', null, 'info');
							}
							$i = $i + 1;
						}
					} else {
						$this->manageMessages('Failed creating thumb path {path} Stopping!', array('{path}' => $thumbDir), 'error');
					}
				} elseif (isset($video['countThumbs'])) {
					$videoModel->thumbs_hosted_on_master_control = true;
					$valid = $video['countThumbs'];
				} elseif (isset($video['thumbUrl'])) {
					$videoModel->thumb_url = $video['thumbUrl'];
					$valid = 1;
				}
				if ($valid !== 0) {
					if ($automaticChangeTitle == true) {
						if ($videoModel->title == $video['title']) {
							$videoModel->status = 1;
						} else {
							$videoModel->status = 1;
						}
					} else {
						$videoModel->status = 1;
					}
					$videoModel->thumbs = $valid;
					if ($videoModel->save()) {
						return true;
					} else {
						return false;
					}
				} else {
//						$videoGrabberModel->delete();
					if ($videoModel->isNewRecord == false) {
						VideoTagsLookup::model()->deleteAll('video_id=:videoId', array(':videoId' => $videoModel->video_id));
						VideoCategory::model()->deleteAll('video_id=:videoId', array(':videoId' => $videoModel->video_id));
						$videoModel->delete();
					}
					$this->manageMessages('Failed to get at least one thumb for {videoUrl}! Dropping video!', array('{videoUrl}' => $video['url']), 'error');
				}
			} else {
				$this->manageMessages('Failed to download video file from url {videoUrl}', array('{videoUrl}' => $videoModel->url), 'error');
			}
		} else {
			$this->manageMessages('Failed to add video {videoUrl} to database!?', array('{videoUrl}' => $video['url']), 'error');
		}
		return false;
	}

	public function updateVideo($values) {
		if (strlen($values['title']) == 0) {
			$this->addError('title', Yii::t('app', 'The title cannot be empty.'));
		}
		if (strlen($values['description']) == 0) {
			$this->addError('description', Yii::t('app', 'The description cannot be empty.'));
		}
		$this->title = $values['title'];
		$this->url = $values['url'];
		$this->thumb_url = $values['thumbUrl'];
		$this->description = $values['desc'];
		$this->embed_code = $values['embed'];
		if ($this->save()) {
			if (is_array($values['categories'])) {
				$command = Yii::app()->db->createCommand('delete from {{video_category}} where video_id=:videoId');
				$command->bindParam(':videoId', $this->video_id);
				$command->execute();
				foreach ($values['categories'] as $category) {
					$videoCategory = new VideoCategory();
					$videoCategory->video_id = $this->video_id;
					$videoCategory->cat_id = $category;
					$videoCategory->save();
				}
			}
			if (is_array($values['tags'])) {
				$command = Yii::app()->db->createCommand('delete from {{video_tags_lookup}} where video_id=:videoId');
				$command->bindParam(':videoId', $this->video_id);
				$command->execute();
				$this->insertTags($values['tags'], $this->video_id);
			}
			return true;
		} else {
			$this->addError('title', Yii::t('app', 'Video could not be saved.'));
			return false;
		}
	}

	protected function insertTags($tags, $videoId) {
		if (is_array($tags) == false) {
			$tags = explode(' ', $tags);
		}
		$tags = array_unique($tags);
		foreach ($tags as $tag) {
			$tag = trim($tag);
			if (strlen($tag) > 2) {
				$dbTag = VideoTags::model()->find(array('condition' => 'name=:name', 'params' => array(':name' => $tag)));
				if (!$dbTag) {
					$dbTag = new VideoTags();
					$dbTag->name = $tag;
					$dbTag->save();
				}
				if ($dbTag) {
					$sql = 'insert ignore into {{video_tags_lookup}} (video_id,tag_id) values (:videoId,:tagId)';
					$command = Yii::app()->db->createCommand($sql);
					$command->bindParam(':videoId', $videoId);
					$command->bindParam(':tagId', $dbTag->tag_id);
					$command->execute();
				}
			}
		}
	}

	protected function manageMessages($message, $variables = null, $level = 'info') {
		if ($level == 'error') {
			$aux = Yii::t('app', $message, $variables);
			Yii::log($aux, 'error', __CLASS__);
			$this->errors[] = $aux;
		} else {
			Yii::log(Yii::t('app', $message, $variables), 'info', __CLASS__);
		}
	}

	protected function match_category($name, $title, $description, $tags) {
		foreach ($this->categories as $category) {
			$category_name = $category->name;
			if ($name != '') {
				if (stripos($category_name, $name) !== FALSE OR
						stripos($name, $category_name) !== FALSE) {
					return array('cat_id' => $category->cat_id, 'parent_cat_id' => $category->parent_cat_id);
				}
			}

			if (stripos($title, $category_name) !== FALSE) {
				return array('cat_id' => $category->cat_id, 'parent_cat_id' => $category->parent_cat_id);
			}

			if (is_string($tags)) {
				if ($tags != '') {
					if (stripos($tags, $category_name) !== FALSE) {
						return array('cat_id' => $category->cat_id, 'parent_cat_id' => $category->parent_cat_id);
					}
				}
			}

			if ($description != '') {
				if (stripos($description, $category_name) !== FALSE) {
					return array('cat_id' => $category->cat_id, 'parent_cat_id' => $category->parent_cat_id);
				}
			}
		}
		$aux = array_rand($this->categories);
		return array('cat_id' => $this->categories[$aux]->cat_id, 'parent_cat_id' => $this->categories[$aux]->parent_cat_id);
	}

	protected function addCategoriesToNewVideo($categories, &$video) {
		if (is_array($categories)) {
			foreach ($categories as $category) {
				if (is_numeric($category)) {
					$videoCategory = VideoCategories::model()->findByPk($category);
					if ($videoCategory) {
						$videoCategoryModel = new VideoCategory();
						$videoCategoryModel->cat_id = $videoCategory->cat_id;
						$videoCategoryModel->parent_cat_id = $videoCategory->parent_cat_id;
						$videoCategoryModel->video_id = $video->video_id;
						$videoCategoryModel->save();
						$video->category_id = $videoCategory->cat_id;
						$video->category_name = $videoCategory->name;
						$video->category_slug = $videoCategory->slug;
						VideoCategories::model()->updateAll(array('total_videos' => 'total_videos+1'), 'cat_id=:catId', array(':catId' => $category));
						VideoCategories::model()->updateAll(array('total_videos' => 'total_videos+1'), 'cat_id=:parentCatId', array(':parentCatId' => $category));
					}
				}
			}
		}
	}

	public function delete() {
		$command = Yii::app()->db->createCommand('delete from {{video_tags_lookup}} where video_id=:videoId');
		$command->bindParam(':videoId', $this->video_id);
		$command->execute();
		$command = Yii::app()->db->createCommand('delete from {{video_category}} where video_id=:videoId');
		$command->bindParam(':videoId', $this->video_id);
		$command->execute();
		parent::delete();
	}

	static public function checkUniqueTitle($title){
		$command=Yii::app()->db->createCommand('select count(*) from {{video}} where title=:title');
		$command->bindParam(':title',$title);
		return $command->queryScalar();
	}
}
