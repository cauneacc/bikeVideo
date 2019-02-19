<?php

/**
  cristianftataru: am vb odata despre asta, nu stiu daca mai tii minte09:25:59 AM
  cauneacc: ala cu reguli, si mastercontrol sa faca link-urile automat?09:26:31 AM
  cristianftataru: siteA.com/tag/$cuvant, sa continta linkuri catre tag-uri similare de pe alte site-uri AGS care au activata acasta optiune09:26:33 AM
  cristianftataru: dar un site nu poate trimite link catre un site care e pe acelasi IP09:26:45 AM
  cauneacc: ok09:26:51 AM
  cauneacc: vroiam sa stiu daca te referi la ce e deja facut, sau trebuie facut09:27:11 AM
  cristianftataru: la ce trebuie facut09:27:18 AM
  cristianftataru: titlul anchorului catre tag-urile externe sa fie titlul paginii catre care se face link
 */
class LinkManagerController extends Controller {

	public function actionPutManagedLink() {
		if ($_POST['url'] and $_POST['name']) {
			$link = ManagedLinks::model()->find('url=:url', array(':url' => $_POST['url']));
			if ($link) {
				header('HTTP/1.1 404 Not Found');
				echo 'The url "' . $_POST['url'] . '" is already in the database';
				exit;
			} else {
				$link = new ManagedLinks();
				$link->name = $_POST['name'];
				$link->url = $_POST['url'];
				$link->description = $_POST['description'];
				if ($link->save()) {
					header('HTTP/1.1 200 OK');
					echo 'Success';
					exit;
				} else {
					header('HTTP/1.1 404 Not Found');
					echo 'Could not save information';
					exit;
				}
			}
		} else {
			header('HTTP/1.1 404 Not Found');
			echo 'No url and name';
			exit;
		}
	}

	public function actionDeleteAllManagedLinks() {
		Yii::app()->db->createCommand('delete from {{managed_links}}')->execute();
		echo 'success';
		exit;
	}

	public function actionPutMultipleManagedLinks() {
		if (isset($_POST['value'])) {
			$aux = unserialize($_POST['value']);
			if ($aux !== false) {
				if (is_array($aux)) {
					$db = Yii::app()->db;
					$checkCommand = $db->createCommand('select count(*) from {{managed_links}} where url=:url');
					$insertCommand = $db->createCommand('insert into {{managed_links}} (name, url,description) values (:name,:url,:description)');
					foreach ($aux as $row) {
						$checkCommand->bindParam(':url', $row['url']);
						if ($checkCommand->queryScalar() == false) {
							$insertCommand->bindParam(':name', $row['name']);
							$insertCommand->bindParam(':url', $row['url']);
							$insertCommand->bindParam(':description', $row['description']);
							$insertCommand->execute();
						}
					}
					echo 'success';
					exit;
				}
			}
		}
		header('HTTP/1.1 404 Not Found');
		echo 'error';
		exit;
	}

	public function actionPutTagLink() {
		if ($_POST['tagId'] && $_POST['title'] && $_POST['target']) {
			$videoTag = VideoTags::model()->findByPk($_POST['tagId']);
			if ($videoTag) {
				$tags = TagLinks::model()->find('tag_id=:tagId', array(':tagId' => $_POST['tagId']));
				$countTags = count($tags);
				if ($countTags < 5) {
					$found = false;
					for ($i = 0; $i < $countTags; $i++) {
						if ($tags->url == $_POST['target']) {
							$found = true;
							$i = $countTags;
						}
					}
					if ($found == false) {
						$tagLinks = new TagLinks();
						$tagLinks->tag_id = $videoTag->tag_id;
						$tagLinks->title = $_POST['title'];
						$tagLinks->url = $_POST['target'];
						if ($tagLinks->save()) {
							header('HTTP/1.1 200 OK');
							echo 'Success';
							exit;
						} else {
							header('HTTP/1.1 404 Not Found');
							echo 'Error saving the information';
							exit;
						}
					} else {
						header('HTTP/1.1 404 Not Found');
						echo 'These link already exist for tag id (' . $_POST['tagId'] . ')';
						exit;
					}
				} else {
					header('HTTP/1.1 404 Not Found');
					echo 'There are enough links for tag (' . $_POST['tagId'] . ')';
					exit;
				}
			} else {
				header('HTTP/1.1 404 Not Found');
				echo 'No such tag (' . $_POST['tagId'] . ')';
				exit;
			}
		} else {
			header('HTTP/1.1 404 Not Found');
			echo 'No tag or title or target';
			exit;
		}
	}

	public function actionDeleteTagLink() {
		if ($_POST['tag']) {
			$videoTag = VideoTags::model()->find('name=:name', array(':name' => $_POST['tag']));
			if ($videoTag) {
				if ($videoTag->delete()) {
					header('HTTP/1.1 200 OK');
					echo 'Success';
					exit;
				} else {
					header('HTTP/1.1 404 Not Found');
					echo 'Error deleting the tag';
					exit;
				}
			} else {
				header('HTTP/1.1 404 Not Found');
				echo 'No such tag (' . $_POST['tag'] . ')';
				exit;
			}
		} else {
			header('HTTP/1.1 404 Not Found');
			echo 'No tag';
			exit;
		}
	}

	public function actionCheckTagLink() {
		if ($_POST['tag']) {
			$videoTag = VideoTags::model()->find('name=:name', array(':name' => $_POST['tag']));
			if ($videoTag) {
				header('HTTP/1.1 200 OK');
				echo 'Exists';
				exit;
			} else {
				header('HTTP/1.1 404 Not Found');
				echo 'No such tag';
				exit;
			}
		} else {
			header('HTTP/1.1 404 Not Found');
			echo 'No tag';
			exit;
		}
	}

	public function actionGetNewTagLInks() {
		if (isset($_POST['tagId'])) {
			$sql = 'SELECT name, tag_id
				FROM {{video_tags}}
				where tag_id>:tagId';
			$command = Yii::app()->db->createCommand($sql);
			$command->bindParam(':tagId', $_POST['tagId']);
			$tags = $command->queryAll();
			echo serialize($tags);
		} else {
			header('HTTP/1.1 404 Not Found');
			echo 'No tag id';
			exit;
		}
	}

	public function actionGetTagPageInformation() {
		if (isset($_POST['tagId'])) {
			$sql = 'SELECT name, tag_id
				FROM {{video_tags}}
				where tag_id=:tagId';
			$command = Yii::app()->db->createCommand($sql);
			$command->bindParam(':tagId', $_POST['tagId']);
			$row = $command->queryRow();
			if ($row) {
				$url = Yii::app()->createAbsoluteUrl('video/tags/index', array('slug' => $row['name']));
				Yii::import('application.modules.video.libraries.BMetaInformation');
				$metaInformation = new BMetaInformation();
				$metaInformation->setMetaInformation($this, BMetaInformation::PAGE_TYPE_TAG, $row['name'], null, ucfirst($row['name']));
				$pageTitle = $this->pageTitle;
				echo serialize(array('url' => $url, 'pageTitle' => $pageTitle));
			}
		} else {
			header('HTTP/1.1 404 Not Found');
			echo 'No tag id';
			exit;
		}
	}

	public function actionDeleteAllTagLinks() {
		if (TagLinks::model()->deleteAll()) {
			echo 'Success';
			exit;
		} else {
			header('HTTP/1.1 404 Not Found');
			echo 'Error';
			exit;
		}
	}

}

?>
