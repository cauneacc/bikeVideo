<?php

/**
 * Advertisement helper class
 * */
class Ad {

	// Display a random, active advertisement
	public static function show($positionTitle, $templateName) {
		$connection = Yii::app()->db;
		/*
		 * the original code took into account the sponsor order, and campaign priority, it's not needed anymore
		$currentAdPriority = self::getCurrentAdPriority();
		$sponsorsAdDisplayPercent = self::getSponsorsPercentAndPriority();
		self::orderSponsorsByProcentAndPriority($sponsorsAdDisplayPercent);
		if (empty($sponsorsAdDisplayPercent)) {
			$sponsorsAdDisplayPercent = self::renewSponsorPercentAndPriority();
			self::orderSponsorsByProcentAndPriority($sponsorsAdDisplayPercent);
		}
		$max = count($sponsorsAdDisplayPercent);
		$order = '';
		for ($x = 0; $x < $max; $x++) {
			$order = $order . ',' . $sponsorsAdDisplayPercent[$x]['sponsorId'];
		}
		$order = substr($order, 1);
		if ($order) {
			 
			$sql = 'SELECT c.* FROM {{advertising_campaign}} AS c
			WHERE c.priority<=\'' . mysql_real_escape_string($currentAdPriority) . '\'
			AND c.start_time < unix_timestamp()
			AND c.end_time > unix_timestamp()
			AND c.status=1
			and c.sponsor_id in (' . $order . ')
			and positions=(select id from {{position}} where title=:positionTitle)
			ORDER BY find_in_set(c.sponsor_id,\'' . $order . '\') ';
			 * 
			 */
			
			$sql = 'SELECT c.* FROM {{advertising_campaign}} AS c
			WHERE c.start_time < unix_timestamp()
			AND c.end_time > unix_timestamp()
			AND c.status=1
			and positions=(select id from {{position}} where title=:positionTitle)';
//			str_replace(array('{{','}}',':positionTitle'), array('tbl_',"'$positionTitle'",), $sql)
//			Yii::log($sql.' '.$positionTitle,'error','aaaaaaaaaaaaaaa');
			$command = $connection->createCommand($sql);
			$command->bindParam(':positionTitle', $positionTitle);
			$advert = $command->queryRow();
			if ($advert) {
				/*
				self::changeSponsorPercent($advert['sponsor_id'], $sponsorsAdDisplayPercent);
				self::setSponsorsPercentAndPriority($sponsorsAdDisplayPercent);
				$sql = sprintf("(%d, %d, %d, '%s', '%s', '%s')", 0, $advert['id'], time(), mysql_real_escape_string($_SERVER['REMOTE_ADDR']), mysql_real_escape_string($_SERVER['REMOTE_HOST']), mysql_real_escape_string($_SERVER['HTTP_USER_AGENT'])
				);
				$logVisitCounter = Yii::app()->cache->get('AdVisitLogCounter');
				if ($logVisitCounter === false) {//there is nothing in the cache, new install or the cache was emptied
					Yii::app()->cache->set('AdVisitLogCounter', 0);
					Yii::app()->cache->set('AdVisitLogSql', 'INSERT INTO ' . UserVisit::tableName() . ' (user_id, advertising_campaign_id, visittime, ip_addr, country, `user_agent`) VALUES ');
				}
				if ($logVisitCounter + 1 >= Yii::app()->params['logAdViewDelay']) {
					$logVisitSql = Yii::app()->cache->get('AdVisitLogSql');
					if (empty($logVisitSql) == false) {
						$logVisitSql = substr($logVisitSql, 0, strlen($logVisitSql) - 1);
					} else {
						Yii::log(Yii::t('app', 'The sql to save the ad views was not in the cache. There might be a problem with the cache. The ad views are not saved.'), 'error', 'advertisement');
					}
					Yii::app()->cache->set('AdVisitLogCounter', 0);
					Yii::app()->cache->set('AdVisitLogSql', 'INSERT INTO ' . UserVisit::tableName() . ' (user_id, advertising_campaign_id, visittime, ip_addr, country, `user_agent`) VALUES ');
				} else {
					Yii::app()->cache->set('AdVisitLogSql', Yii::app()->cache->get('AdVisitLogSql') . $sql . ',');
					Yii::app()->cache->set('AdVisitLogCounter', $logVisitCounter + 1);
				}
				 * 
				 */
				if ($advert['mode'] == 'image') {
					echo CHtml::image(
							Yii::app()->baseUrl . '/images/banner/' . $advert['url_picture'], '');
				} else if ($advert['mode'] == 'text') {
					$aux = @json_decode($advert['text']);
					if (is_object($aux)) {
						$template = AdvertisingTemplate::getCacheTemplateForPosition($templateName, $positionTitle);
						echo str_replace(array('{title}', '{line1}', '{line2}', '{line3}', '{visibleUrl}'), array($aux->title, $aux->line1, $aux->line2, $aux->line3, $aux->visibleUrl), $template);
					}
				} else if ($advert['mode'] == 'script' || $advert['mode'] == 'dhtml') {
					echo $advert['script'];
				}
			}
	}

	public static function ert($a) {
		foreach ($a as $b) {
			echo 'sponsor ' . $b['sponsorId'] . ' => ' . $b['percent'] . ' ' . $b['priority'] . '<br />';
		}
	}

	public function module() {
		return Yii::app()->getModule('advertisement');
	}

	public static function setCurrentSponsorPriority($priority) {
		return Yii::app()->cache->set('advertisementSponsorPriority', $priority);
	}

	public static function orderSponsorsByProcentAndPriority(&$sponsorsAdDisplayPercent) {
		$max = count($sponsorsAdDisplayPercent);
		for ($x = 0; $x < $max; $x++) {
			if ($sponsorsAdDisplayPercent[$x]['percent'] == 0) {
				unset($sponsorsAdDisplayPercent[$x]);
			}
		}
		$sponsorsAdDisplayPercent = array_values($sponsorsAdDisplayPercent);
		$max = count($sponsorsAdDisplayPercent);
		for ($x = 0; $x < $max; $x++) {
			for ($y = 1; $y < $max; $y++) {
				if ($sponsorsAdDisplayPercent[$x]['priority'] < $sponsorsAdDisplayPercent[$y]['priority']) {
					$hold = $sponsorsAdDisplayPercent[$x];
					$sponsorsAdDisplayPercent[$x] = $sponsorsAdDisplayPercent[$y];
					$sponsorsAdDisplayPercent[$y] = $hold;
				}
			}
		}
//		echo __FILE__ . ' ' . __LINE__ . '<pre>' . PHP_EOL;
//		var_dump($sponsorsAdDisplayPercent);
//		echo '</pre>' . PHP_EOL;
	}

	public static function getCurrentSponsorPriority() {
		$priority = Yii::app()->cache->get('advertisementSponsorPriority');
		if ($priority === false) {
			$connection = Yii::app()->db;
			$sql = 'select max(priority) as max from {{advertising_sponsor}}';
			$command = $connection->createCommand($sql);
			$row = $command->queryRow();
			if ($row != false) {
				self::setCurrentSponsorPriority($row['max']);
				return $row['max'];
			} else {
				return false;
			}
		} else {
			return $priority;
		}
	}

	public static function setCurrentAdPriority($priority) {
		return Yii::app()->cache->set('advertisementAdPriority', $priority);
	}

	public static function getCurrentAdPriority() {
		$priority = Yii::app()->cache->get('advertisementAdPriority');
		if ($priority === false) {
			$connection = Yii::app()->db;
			$sql = 'select max(priority) as max from {{advertising_campaign}}';
			$command = $connection->createCommand($sql);
			$row = $command->queryRow();
			if ($row != false) {
				self::setCurrentAdPriority($row['max']);
				return $row['max'];
			} else {
				return false;
			}
		} else {
			return $priority;
		}
	}

	public static function setSponsorsPercentAndPriority($percents) {
		$a = Yii::app()->cache->set('sponsorsAdDisplayPercentAndPriority', $percents);
		return $a;
	}

	public static function getSponsorsPercentAndPriority() {
		$percents = Yii::app()->cache->get('sponsorsAdDisplayPercentAndPriority');
		if ($percents === false) {
			return self::renewSponsorPercentAndPriority();
		} else {
			return $percents;
		}
	}

	public static function renewSponsorPercentAndPriority() {
		$sql = 'select id as sponsorId, percent, priority from {{advertising_sponsor}}';
		$command = Yii::app()->db->createCommand($sql);
		$percents = $command->queryAll();
		Yii::app()->cache->set('sponsorsAdDisplayPercentAndPriority', $percents);
		return $percents;
	}

	public static function changeSponsorPercent($sponsorId, &$percents) {
		$max = count($percents);
		$i = 0;
		while ($i < $max) {
			if ($percents[$i]['sponsorId'] == $sponsorId) {
				if ($percents[$i]['percent'] - 1 < 0) {
					$percents[$i]['percent'] = 0;
				} else {
					$percents[$i]['percent'] = $percents[$i]['percent'] - 1;
				}
				$i = $max;
			}
			$i = $i + 1;
		}
	}

}

?>