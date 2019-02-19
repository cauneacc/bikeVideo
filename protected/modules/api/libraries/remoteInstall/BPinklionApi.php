<?php

Yii::import('ext.crawlers.libraries.BCurl');

class BPinklionApi {


	public function deleteSite($siteUrl) {
		$url = Yii::app()->params['pinklionApiUrl'] . '/supprimer_hebergement.php?cle=' . Yii::app()->params['pinklionApiKey'] . '&domaine=' . $siteUrl;
		$result = $this->makeRequest($url);
		if (is_array($result)) {
			return $result;
		} elseif (is_object($result)) {
			if ($result->etat == 'ok') {
				return true;
			} else {
				return array(false, false);
			}
		}
	}

	public function getSiteData($siteUrl) {
		$domain = $this->getDomainForSite($siteUrl);
		$url = Yii::app()->params['pinklionApiUrl'] . '/infos_hebergement.php?cle=' . Yii::app()->params['pinklionApiKey'] . '&domaine=' . $domain;
		$result = $this->makeRequest($url);
		if (is_array($result)) {
			return $result;
		} elseif (is_object($result)) {
			if ($result->etat[0] == 'ok' or $result->etat[0] == 'actif') {
				if (empty($result->erreur) == false) {
					return array(false, $result->erreur);
				} else {
					return array ('name'=>(string) $result->sql_login,
							'password'=>(string) $result->sql_pass,
						'user'=>(string) $result->sql_login);
				}
			} else {
				return array(false, false);
			}
		}
	}

	protected function getDomainForSite($siteUrl) {
		$domain = parse_url($siteUrl, PHP_URL_HOST);
		if ($domain == null) {
			$domain = str_replace('/', '', $siteUrl);
		}
		return $domain;
	}

	public function createSite($siteUrl) {
		$domain = $this->getDomainForSite($siteUrl);
		$url = Yii::app()->params['pinklionApiUrl'] . '/creer_hebergement.php?cle=' . Yii::app()->params['pinklionApiKey'] . '&domaine=' . $domain. '&ip';
		$result = $this->makeRequest($url);
//		$result = new stdClass();
//		$result->etat = 'ok';
		if (is_array($result)) {
			return $result;
		} elseif (is_object($result)) {
			if ($result->etat == 'ok') {
				$url = Yii::app()->params['pinklionApiUrl'] . '/infos_hebergement.php?cle=' . Yii::app()->params['pinklionApiKey'] . '&domaine=' . $domain;
				$result = $this->makeRequest($url);
				if (is_array($result)) {
					return $result;
				} elseif (is_object($result)) {
					if ($result->etat[0] == 'ok') {
						if (empty($result->erreur) == false) {
							return array(false, $result->erreur);
						} else {
							return array(true, false);
						}
					} else {
						return array(false, false);
					}
				}else{
					return array(false, false);
				}
			} else {
				return array(false, false);
			}
		} else {
			return array(false, false);
		}
	}

	protected function makeRequest($url) {
		if ($_SERVER['HTTP_HOST'] == 'mastercontrol') {
			$url=substr($url, strpos($url, '/api/')+4);
			$key = 'Note: I used this simple bash: `locate libmcrypt` from terminal on Mac OS X to determine the install paths to the algorithms and ';
			$encrypted = $this->urlsafe_b64encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $url, MCRYPT_MODE_CBC, md5(md5($key))));
			
			$url = 'http://junkgrid.com/testPinklionApi.php?e=' . $encrypted;
		}
		$result = BCurl::string($url);
		if ($result) {
			$xmlResult = new SimpleXMLElement($result);
			if ($xmlResult->etat == 'nok') {
				$message = 'Trying to make request with url  "' . $url . '" failed. Received error message "' . $xmlResult->erreur . '"';
				Yii::log($message, 'error', 'BPinklionApi');
				return array(false, $message);
			} else {
				return $xmlResult;
			}
		} else {
			$message = 'Didn\'t receive an answer from url "' . $url . '" .';
			Yii::log($message, 'error', 'BPinklionApi');
			return array(false, $message);
		}
	}

	function urlsafe_b64encode($string) {
		$data = base64_encode($string);
		$data = str_replace(array('+', '/', '='), array('-', '_', '.'), $data);
		return $data;
	}


}

?>
