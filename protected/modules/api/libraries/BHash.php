<?php
class BHash{

	function checkHash($get, $post){
		$qLength=strlen($get['h']);
		$middle=$qLength / 2;
		$firstPart=substr($get['h'], $middle - 20, 20);
		$secondPart=substr($get['h'], $middle, 20);
		$hash=$firstPart.$secondPart;
		unset($get['h']);
		$params=array_merge($get, $post);
		$signature=$this->generateSignature($params);
		if($signature == $hash){
			return true;
		}else{
			return false;
		}
	}

	protected function generateSignature(array $params) {
		$reqString = Yii::app()->params['apiSalt'];
		if ($reqString) {
			ksort($params);
			foreach ($params as $k => $v) {
				if (is_int($v)) {
					$reqString .= $k . serialize((string) $v);
				} elseif (is_bool($v)) {
					$reqString .= $k . serialize((string) $v);
				} elseif (is_null($v)) {
					$reqString .= $k . serialize((string) $v);
				} elseif (is_array($v)) {
					if (empty($v) == false) {
						foreach ($v as $key => $value) {
							$v[$key] = (string) $value;
						}
						$reqString .= $k . serialize($v);
					}
				} else {
					$reqString .= $k . serialize($v);
				}
			}
			return sha1($reqString);
		}else{
			Yii::log(Yii::t('masterControl','The api salt parameter is empty'),'error',__CLASS__);
			exit(Yii::t('masterControl','The api salt parameter is empty'));
		}
	}

	function generateHash(array $params){
		$length=rand(1,17);
		return $this->generateRandStr($length).$this->generateSignature($params).$this->generateRandStr($length);
	}

	protected function generateRandStr($length){
		$randstr='';
		for($i=0; $i < $length; $i++){
			$randnum=mt_rand(0, 61);
			if($randnum < 10){
				$randstr .= chr($randnum + 48);
			}else if($randnum < 36){
				$randstr .= chr($randnum + 55);
			}else{
				$randstr .= chr($randnum + 61);
			}
		}
		return strtolower($randstr);
	}

}
?>
