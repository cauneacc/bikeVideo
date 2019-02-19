<?php

class BSitemap {

	function createSitemap() {
		$sitemapsBaseFolder=dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR .'sitemaps'.DIRECTORY_SEPARATOR.$this->getHost(Yii::app()->params['rootUrl']).DIRECTORY_SEPARATOR;
		$sitemapNames = array();
		$i = 1;
		$sitemapNumber = 0;
		$connection = Yii::app()->db;
		$command = $connection->createCommand('select * from {{video}} where status=1');
		$dataReader = $command->query();
		$filename = 'sitemap' . $sitemapNumber . '.xml';
		$sitemapNames[] = $filename;
		$lastLetter = substr(Yii::app()->params['rootUrl'], -1);
		if ($lastLetter == '/') {
			Yii::app()->params['rootUrl'] = substr(Yii::app()->params['rootUrl'], 0,strlen(Yii::app()->params['rootUrl'])-1);
		} 
//videos
		$sitemapFileHandle = fopen($sitemapsBaseFolder. $filename, 'w');
		fwrite($sitemapFileHandle, '<?xml version="1.0" encoding="utf-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');
		while (($row = $dataReader->read()) !== false) {
			$string = '<url>
			  <loc>' . Yii::app()->params['rootUrl'] .'/'. substr(Yii::app()->createUrl('video/default/view', array('id' => $row['video_id'], 'slug' => $row['slug'])), 1) . '</loc>
			  <lastmod>' . date('Y-m-d', $row['publish_time']) . '</lastmod>
			  <changefreq>monthly</changefreq>
			  <priority>0.5</priority>
			</url>';
			fwrite($sitemapFileHandle, $string);
			$i = $i + 1;
			if ($i % 45000 === 0) {
				$this->initializeSitemap($sitemapFileHandle, $sitemapNumber, $sitemapsBaseFolder.$filename, $sitemapNames);
			}
		}
//videos pagination
		$command = $connection->createCommand('select count(*) as count from {{video}} where status=1');
		$dataReader = $command->query();
		$row = $dataReader->read();
		if ($row != false) {
			$pages = ceil($row['count'] / (int) Yii::app()->params['videosPerPage']);
			$string = '<url>
			  <loc>' . Yii::app()->params['rootUrl'].'/' . substr(Yii::app()->createUrl('video/default/index'), 1) . '</loc>
			  <changefreq>daily</changefreq>
			  <priority>0.3</priority>
			</url>';
			for ($j = 1; $j <= $pages; $j = $j + 1) {
				$string = '
			<url>
			  <loc>' . Yii::app()->params['rootUrl'] .'/'. substr(Yii::app()->createUrl('video/default/index', array('page' => $j)), 1) . '</loc>
			  <changefreq>daily</changefreq>
			  <priority>0.3</priority>
			</url>';
				fwrite($sitemapFileHandle, $string);
				$i = $i + 1;
				if ($i % 45000 === 0) {
					$this->initializeSitemap($sitemapFileHandle, $sitemapNumber, $sitemapsBaseFolder.$filename, $sitemapNames);
				}
			}
		}
//video tags
		$command = $connection->createCommand('select * from {{video_tags}}');
		$dataReader = $command->query();
		while (($row = $dataReader->read()) !== false) {
			$command1 = $connection->createCommand('select count(*) as count from {{video_tags_lookup}} where tag_id=:tagId');
			$command1->bindParam(":tagId", $row['tag_id'], PDO::PARAM_STR);
			$dataReader1 = $command1->query();
			$row1 = $dataReader1->read();
			if ($row1 != false) {
				$pages = ceil($row1['count'] / (int) Yii::app()->params['videosPerPage']);
				$string = '<url>
				  <loc>' . Yii::app()->params['rootUrl'] .'/'. substr(Yii::app()->createUrl('video/tags/index', array('slug' => $row['name'])), 1) . '</loc>
				  <changefreq>daily</changefreq>
				  <priority>0.3</priority>
				</url>';
				fwrite($sitemapFileHandle, $string);
				for ($j = 2; $j <= $pages; $j = $j + 1) {
					$string = '<url><loc>' . Yii::app()->params['rootUrl'] .'/'. substr(Yii::app()->createUrl('video/tags/index', array('slug' => $row['name'], 'page' => $j)), 1) . '</loc><changefreq>daily</changefreq><priority>0.3</priority></url>';
					fwrite($sitemapFileHandle, $string);
					$i = $i + 1;
					if ($i % 45000 === 0) {
						$this->initializeSitemap($sitemapFileHandle, $sitemapNumber, $sitemapsBaseFolder.$filename, $sitemapNames);
					}
				}
			}
		}
//suggest pages
		$command = $connection->createCommand('select * from {{seo_keywords_page}} where word not in (select word from {{keywords_blacklist}})');
		$dataReader = $command->query();
		while (($row = $dataReader->read()) !== false) {
			$string = '<url>
			   <loc>' . Yii::app()->params['rootUrl'] .'/'. substr(Yii::app()->createUrl('video/suggest/index', array('slug' => $row['word'])), 1) . '</loc>
			   <changefreq>daily</changefreq>
			   <priority>0.3</priority>
			</url>';
			fwrite($sitemapFileHandle, $string);
			$i = $i + 1;
			if ($i % 45000 === 0) {
				$this->initializeSitemap($sitemapFileHandle, $sitemapNumber, $sitemapsBaseFolder.$filename, $sitemapNames);
			}
		}

//video parent categories
		$command = $connection->createCommand('select * from {{video_categories}} where status=\'1\' and parent_cat_id=0');
		$dataReader = $command->query();
		while (($row = $dataReader->read()) !== false) {
			$command1 = $connection->createCommand('select count(*) as count from {{video_category}} where cat_id=:catId');
			$command1->bindParam(":catId", $row['cat_id'], PDO::PARAM_STR);
			$dataReader1 = $command1->query();
			$row1 = $dataReader1->read();
			if ($row1 != false) {
				$pages = ceil($row1['count'] / (int) Yii::app()->params['videosPerPage']);
				$string = '
			<url>
			    <loc>' . Yii::app()->params['rootUrl'] .'/'. substr(Yii::app()->createUrl('video/categories/index', array('id' => $row['cat_id'], 'slug' => $row['slug'])), 1) . '</loc>
				<changefreq>daily</changefreq>
				<priority>0.3</priority>
		    </url>';
				fwrite($sitemapFileHandle, $string);

				for ($j = 1; $j <= $pages; $j = $j + 1) {
					$string = '
			<url>
			    <loc>' . Yii::app()->params['rootUrl'] .'/'. substr(Yii::app()->createUrl('video/categories/index', array('id' => $row['cat_id'], 'slug' => $row['slug'], 'page' => $j)), 1) . '</loc>
				<changefreq>daily</changefreq>
				<priority>0.3</priority>
			</url>';
					fwrite($sitemapFileHandle, $string);
					$i = $i + 1;
					if ($i % 45000 === 0) {
						$this->initializeSitemap($sitemapFileHandle, $sitemapNumber, $sitemapsBaseFolder.$filename, $sitemapNames);
					}
				}
			}
		}

//video child categories
		$command = $connection->createCommand('select * from {{video_categories}} where status=\'1\' and parent_cat_id!=0');
		$dataReader = $command->query();
		while (($row = $dataReader->read()) !== false) {
			$command1 = $connection->createCommand('select count(*) as count from {{video_category}} where cat_id=:catId');
			$command1->bindParam(":catId", $row['cat_id'], PDO::PARAM_STR);
			$dataReader1 = $command1->query();
			$row1 = $dataReader1->read();
			if ($row1 != false) {
				$pages = ceil($row1['count'] / (int) Yii::app()->params['videosPerPage']);
				$string = '
			<url>
			    <loc>' . Yii::app()->params['rootUrl'] .'/'. substr(Yii::app()->createUrl('video/categories/index', array('id' => $row['cat_id'], 'slug' => $row['slug'])), 1) . '</loc>
				<changefreq>daily</changefreq>
				<priority>0.3</priority>
			</url>';
				fwrite($sitemapFileHandle, $string);

				for ($j = 1; $j <= $pages; $j = $j + 1) {
					$string = '<url><loc>' . Yii::app()->params['rootUrl'].'/' . substr(Yii::app()->createUrl('video/categories/index', array('id' => $row['cat_id'], 'slug' => $row['slug'], 'page' => $j)), 1) . '</loc><changefreq>daily</changefreq><priority>0.3</priority></url>';
					fwrite($sitemapFileHandle, $string);
					$i = $i + 1;
					if ($i % 45000 === 0) {
						$this->initializeSitemap($sitemapFileHandle, $sitemapNumber, $sitemapsBaseFolder.$filename, $sitemapNames);
					}
				}
			}
		}
		fwrite($sitemapFileHandle, '</urlset>');
		fclose($sitemapFileHandle);

//video sitemap
		$command = $connection->createCommand('SELECT v.*,c.name AS category_name
			FROM {{video}} AS v
			LEFT JOIN {{video_category}} AS l
			ON (v.video_id=l.video_id)
			LEFT JOIN {{video_categories}} AS c
			ON (l.cat_id=c.cat_id)
			WHERE v.status=1
			group by video_id');
		$dataReader = $command->query();

		$filename = 'videoSitemap' . $sitemapNumber . '.xml';
		$sitemapNames[] = $filename;
		$sitemapFileHandle = fopen($sitemapsBaseFolder . $filename, 'w');
		fwrite($sitemapFileHandle, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" 
		        xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">');
		
		$searchArray=array('$title','$description','$keywords');
		while (($row = $dataReader->read()) !== false) {
			$thumbUrl = '';
			if ($row['thumb_url'] != '') {
				$thumbUrl = $row['thumb_url'];
			} else {
				$thumbUrl = Yii::app()->params['rootUrl'].'/images/videos/tmb/' . BImage::createVideoThumbPartialUrl($row['video_id']) . '/1.jpg';
			}
			$pageTitle=$row['title'];
			if(isset(Yii::app()->params['videoViewPageTitle'])){
				$replaceArray=array($row['title'],'',$row['description']);
				$pageTitle=str_replace($searchArray, $replaceArray, Yii::app()->params['videoViewPageTitle']);
			}
			$string = '<url>
         <loc>' . Yii::app()->params['rootUrl'] .'/'. substr(Yii::app()->createUrl('video/default/view', array('id' => $row['video_id'], 'slug' => $row['slug'])), 1) . '</loc>
	     <video:video>
		    <video:thumbnail_loc>' . $thumbUrl . '</video:thumbnail_loc>
		    <video:title>' . html_entity_decode($row['title'],ENT_NOQUOTES,'UTF-8').' - '.Yii::app()->params['siteName'].' - ' .html_entity_decode($pageTitle,ENT_NOQUOTES,'UTF-8'). '</video:title>';
			if ($row['description'] == '') {
				$string = $string . '
		    <video:description>' . html_entity_decode($row['title'],ENT_NOQUOTES,'UTF-8').' - '.Yii::app()->params['siteName']  . '</video:description>';
			} else {
				$string = $string . '
		    <video:description>' . html_entity_decode($row['description'],ENT_NOQUOTES,'UTF-8').' - '.Yii::app()->params['siteName'] . '</video:description>';
			}
			
		    $string = $string . '
			<video:duration>' . $row['duration'] . '</video:duration>';
			if (empty($row['publish_time']) == false) {
				$string = $string . '
			<video:publication_date>' . str_replace(' ','T',$row['publish_time']).'+03:00' . '</video:publication_date>';
			}
			$command1 = $connection->createCommand('SELECT t.name
					FROM {{video_tags_lookup}} AS l
					INNER JOIN {{video_tags}} AS t
					ON (l.tag_id=t.tag_id)
					WHERE video_id=:videoId');
			$command1->bindParam(":videoId", $row['video_id'], PDO::PARAM_STR);
			$dataReader1 = $command1->query();
			while (($row1 = $dataReader1->read()) !== false) {
				$string = $string . '
			<video:tag>' . html_entity_decode($row1['name'],ENT_NOQUOTES,'UTF-8') . '</video:tag>';
			}
			if (empty($row['category_name']) == false) {
				$string = $string . '
			<video:category>' . $row['category_name'] . '</video:category>';
			}
			$string = $string . '
			<video:family_friendly>no</video:family_friendly>
		</video:video>
	</url>';
//	   echo $string.PHP_EOL;
			fwrite($sitemapFileHandle, $string);
			$i = $i + 1;
			if ($i % 45000 === 0) {
				$this->initializeVideoSitemap($sitemapFileHandle, $sitemapNumber, $sitemapsBaseFolder.$filename, $sitemapNames);
			}
		}
		fwrite($sitemapFileHandle, '
		</urlset>');
		fclose($sitemapFileHandle);


//create sitemap index
		$indexSitemapFileHandle = fopen($sitemapsBaseFolder. 'sitemap.xml', 'w');
		fwrite($indexSitemapFileHandle, '<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');

//		foreach ($sitemapNames as $name) {
//			$file = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $name . '.gz';
//			if (is_file($file)) {
//				unlink($file);
//			}
//			exec('gzip ' . dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $name);
//			fwrite($indexSitemapFileHandle, '<sitemap><loc>' . Yii::app()->params['rootUrl'] . '/' . $name . '.gz</loc><lastmod>' . date('Y-m-d') . '</lastmod></sitemap>');
//		}
		foreach ($sitemapNames as $name) {
			fwrite($indexSitemapFileHandle, '<sitemap><loc>' . Yii::app()->params['rootUrl'] . '/' . $name . '</loc><lastmod>' . date('Y-m-d') . '</lastmod></sitemap>');
		}

		fwrite($indexSitemapFileHandle, '</sitemapindex>');
		fclose($indexSitemapFileHandle);
		//submit sitemap index to google
		Yii::import('ext.crawlers.libraries.BCurl');
		BCurl::string('http://www.google.com/webmasters/tools/ping?sitemap=' . urlencode(Yii::app()->params['rootUrl'].'/sitemap.xml'));
		return true;
	}

	protected function initializeSitemap(&$sitemapFileHandle, &$sitemapNumber, $filename, &$sitemapNames) {
		fwrite($sitemapFileHandle, '</urlset>');
		fclose($sitemapFileHandle);
		$sitemapNumber = $sitemapNumber + 1;
		$filename = 'sitemap' . $sitemapNumber . '.xml';
		$sitemapFileHandle = fopen( $filename, 'w');
		fwrite($sitemapFileHandle, '<?xml version="1.0" encoding="utf-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');
		$sitemapNames[] = $filename;
	}

	protected function initializeVideoSitemap(&$sitemapFileHandle, &$sitemapNumber, $filename, &$sitemapNames) {
		fwrite($sitemapFileHandle, '</urlset>');
		fclose($sitemapFileHandle);
		$sitemapNumber = $sitemapNumber + 1;
		$filename = 'videoSitemap' . $sitemapNumber . '.xml';
		$sitemapFileHandle = fopen($filename, 'w');
		fwrite($sitemapFileHandle, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">');
		$sitemapNames[] = $filename;
	}

	protected function getStringBetween($text, $startString, $endString) {
		$start = strpos($text, $startString);
		$end = strpos(substr($text, $start + strlen($startString)), $endString);
		return substr($text, $start + strlen($startString), $end);
	}

	protected function getHost($rootUrl){
		return parse_url($rootUrl, PHP_URL_HOST);
	}
}

?>
