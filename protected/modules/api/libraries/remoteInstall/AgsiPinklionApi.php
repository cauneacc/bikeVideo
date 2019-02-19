<?php

/**
 * Inserts in the database the information needed to create a new site
 *
 * @author claudiu
 */
class AgsiPinklionApi {

	function deleteHosting($siteName) {
		$r = $this->checkRequestIpAndDomainName($siteName);
		if ($r === true) {
// Enregistrement de la demande
			$command = Yii::app()->dbRoot->createCommand('INSERT INTO suppression SET domaine = :domain', array(':domain' => $siteName));
			$command->bindParam(':domain', $siteName, PDO::PARAM_STR);
			$command->execute();
			return true;
		} else {
			Yii::log('Pinklion api failed to delete hosting for site "'.$siteName.'". The error was "'.$r['message'].'"','error',__CLASS__);
			return false;
		}
	}

	function createHosting($siteName, $ip) {
		$r = $this->checkRequestIpAndDomainName($siteName);
		if ($r['result'] === false and $r['message'] = 'Domain name does not exist') {
// Test du paramètre IP
			if ($ip != '' && $ip != 'unique') {
				// Test de l'IP
				$command = Yii::app()->dbRoot->createCommand('SELECT ip, bloque FROM ips WHERE ip = :ip');
				$command->bindParam(':ip', $ip, PDO::PARAM_STR);
				$test_ip = $command->queryAll();
				// L'IP n'existe pas
				if (empty($test_ip)) {
					return array('result' => false, 'message' => 'The ip "' . $ip . '" is not installed on the server');
				} else {// L'IP existe
					// L'IP est bloqué pour une utilisation unique
					if ($test_ip[0]['bloque'] == 'oui') {
						return array('result' => false, 'message' => 'The ip "' . $ip . '" is blocked. The ip is used, and can be used only once.');
					}
				}
			}
			if ($ip == 'unique') {
				$var_ip = '';
				$var_ip_unique = 'oui';
			} else {
				$var_ip = $ip;
				$var_ip_unique = 'non';
			}
// Enregistrement de la demande
			$command = Yii::app()->dbRoot->createCommand('INSERT INTO hebergements SET domaine =:domaine 
								, etat = "a_creer"
								, ip = :ip 
								, ip_unique = :ipUnique', array(':domaine' => $siteName, ':ip' => $var_ip, ':ipUnique' => $var_ip_unique));
			$command->bindParam(':domaine', $siteName, PDO::PARAM_STR);
			$command->bindParam(':ip', $var_ip, PDO::PARAM_STR);
			$command->bindParam(':ipUnique', $var_ip_unique, PDO::PARAM_STR);
			$command->execute();
			return array('result' => true);
		} else {
			return $r;
		}
	}

	function modifyHostingIp($siteName, $ip) {
		$r = $this->checkRequestIpAndDomainName($siteName);
		if ($r === true) {
// Test du paramètre IP
			$command = Yii::app()->dbRoot->createCommand('SELECT ip, bloque FROM ips WHERE ip = :ip', array(':ip' => $ip));
			$command->bindParam(':ip', $ip, PDO::PARAM_STR);
			$test_ip = $command->queryAll();
// L'IP n'existe pas
			if (empty($test_ip)) {
				return array('result' => false, 'message' => 'The ip "' . $ip . '" is not installed on the server');
			} else {// L'IP existe
				// L'IP est bloqué pour une utilisation unique
				if ($test_ip[0]['bloque'] == 'oui') {
					return array('result' => false, 'message' => 'The ip "' . $ip . '" is blocked. The ip is used, and can be used only once.');
				}
			}
// Enregistrement de la demande
			$command = Yii::app()->dbRoot->createCommand('SELECT * FROM hebergements WHERE domaine = :domain');
			$command->bindParam(':domain', $siteName, PDO::PARAM_STR);
			$testDomain = $command->queryAll();
			$command = Yii::app()->dbRoot->createCommand('UPDATE hebergements SET ip = :ip, ip_unique = "non"');
			$command->bindParam(':ip', $ip, PDO::PARAM_STR);
			$command->execute();
			$command = Yii::app()->dbRoot->createCommand('UPDATE ips SET nb_sites = nb_sites + 1 WHERE ip = :ip');
			$command->bindParam(':ip', $ip, PDO::PARAM_STR);
			$command->execute();
			$command = Yii::app()->dbRoot->createCommand('UPDATE ips SET nb_sites = nb_sites - 1, bloque = "non" WHERE ip = :ip');
			$command->bindParam(':ip', $testDomain[0]['ip'], PDO::PARAM_STR);
			$command->execute();
			return true;
		} else {
			return $r;
		}
	}

	function getHostingInformation($siteName) {
		$r = $this->checkRequestIpAndDomainName($siteName);
		if ($r === true) {
			$command = Yii::app()->dbRoot->createCommand('SELECT * FROM hebergements WHERE domaine = :domain', array(':domain' => $siteName));
			$command->bindParam(':domain', $siteName, PDO::PARAM_STR);
			$info = $command->queryAll();
			return $info[0];
		} else {
			return $r;
		}
	}

	protected function checkRequestIpAndDomainName($siteName) {
// Test du domaine
		if (!$this->verifier_hostname($siteName)) {
			Yii::log('Invalid domain name. The domain name received was "' . $siteName . '"', 'error', __CLASS__);
			return array('result' => false, 'message' => 'Invalid domain name');
		} else {
// Test de l'existence du domaine
			$command = Yii::app()->dbRoot->createCommand('SELECT * FROM hebergements WHERE domaine = :domain');
			$command->bindParam(':domain', $siteName, PDO::PARAM_STR);
			$testDomain = $command->queryAll();
			if (empty($testDomain)) {
				return array('result' => false, 'message' => 'Domain name does not exist');
			} else {
				return true;
			}
		}
	}

// Vérification d'un hostname
	protected function verifier_hostname($hostname) {
		if (preg_match("/^[a-z0-9][a-z0-9\-]+[a-z0-9]\.[a-z]{2,4}$/i", $hostname) || preg_match("/^[a-z0-9]([a-z0-9\-]+)?[a-z0-9]\.[a-z0-9][a-z0-9\-]+[a-z0-9]\.[a-z]{2,4}$/i", $hostname))
			return true;
		else
			return false;
	}

// Générer un login SQL
	protected function generer_login_sql($domaine) {
		// Nettoyage
		$domaine = str_replace('.', '', $domaine);
		$domaine = str_replace('-', '', $domaine);
		$domaine = str_replace('_', '', $domaine);
		$domaine = substr($domaine, 0, 10);
		$login = $domaine;
		// Recherche d'un login libre
		$i = 1;
		while (file_exists('/home/mysql/' . $login)) {
			$login = $domaine . $i;
			$i++;
		}
		return $login;
	}

// Générer un mot de passe
	protected function generer_motdepasse($taille = 10) {
		$caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		srand((double) microtime() * 1000000);
		for ($i = 0; $i < $taille; $i++)
			$motdepasse.=substr($caracteres, rand(0, strlen($caracteres) - 1), 1);
		return $motdepasse;
	}

}

?>
