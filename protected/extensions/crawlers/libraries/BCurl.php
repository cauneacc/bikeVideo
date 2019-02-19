<?php
class BCurl{
	const curl_verbose=false;
	const curl_progress=false;
	const curl_timeout=3000;
	const curl_useragent='Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8';

	public static function string($url, $cookie=NULL){
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::curl_timeout);
		curl_setopt($ch, CURLOPT_VERBOSE, self::curl_verbose);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_NOPROGRESS, self::curl_progress);
		curl_setopt($ch, CURLOPT_USERAGENT, self::curl_useragent);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		if($cookie){
			curl_setopt($ch, CURLOPT_COOKIE, $cookie);
		}
		$string=curl_exec($ch);
		if(curl_errno($ch)){
			echo var_dump(curl_error($ch));
			return FALSE;
		}
		curl_close($ch);
		return $string;
	}

	public static function post($url, $options=array(), $cookie=NULL){
		$ch=curl_init();
	}

	public static function file($url, $file, $cookie=NULL){
		$ch=curl_init();
		$fh=fopen($file, 'w');
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FILE, $fh);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::curl_timeout);
		curl_setopt($ch, CURLOPT_VERBOSE, self::curl_verbose);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_NOPROGRESS, self::curl_progress);
		curl_setopt($ch, CURLOPT_USERAGENT, self::curl_useragent);
		if($cookie){
			curl_setopt($ch, CURLOPT_COOKIE, $cookie);
		}
		curl_exec($ch);
		if(curl_errno($ch)){
			return FALSE;
		}
		curl_close($ch);
		fclose($fh);
		if(filesize($file) > 10){
			return TRUE;
		}
		return FALSE;
	}

	public static function size($url, $cookie=NULL){
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_NOBODY, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::curl_timeout);
		curl_setopt($ch, CURLOPT_VERBOSE, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_USERAGENT, self::curl_useragent);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		if($cookie){
			curl_setopt($ch, CURLOPT_COOKIE, $cookie);
		}
		$head=curl_exec($ch);
		if(curl_errno($ch)){
			return FALSE;
		}
		curl_close($ch);
		$regex='/Content-Length:\s([0-9].+?)\s/';
		$count=preg_match($regex, $head, $matches);
		return isset($matches['1']) ? self::transformBytes($matches['1']) : 'unknown';
	}

	private static function transformBytes($bytes){
		$i = 0;
		$formats = array('B','KB','MB','GB');
		while ($bytes >= 1024) {
			$bytes = $bytes / 1024;
			++$i;
		}
		return number_format($bytes,($i ? 2 : 0), ',', '.').' '.$formats[$i];
	}


	public static function stringConcomitent($urls,$cookie=null){
		$handles=array();
		$mh = curl_multi_init();
		foreach($urls as $key=>$url){
			$handles[$key] = curl_init();
			curl_setopt($handles[$key], CURLOPT_URL, $url);
			curl_setopt($handles[$key], CURLOPT_HEADER, FALSE);
			curl_setopt($handles[$key], CURLOPT_CONNECTTIMEOUT, self::curl_timeout);
			curl_setopt($handles[$key], CURLOPT_VERBOSE, self::curl_verbose);
			curl_setopt($handles[$key], CURLOPT_FOLLOWLOCATION, TRUE);
			curl_setopt($handles[$key], CURLOPT_NOPROGRESS, self::curl_progress);
			curl_setopt($handles[$key], CURLOPT_USERAGENT, self::curl_useragent);
			curl_setopt($handles[$key], CURLOPT_RETURNTRANSFER, TRUE);
			if($cookie){
				curl_setopt($handles[$key], CURLOPT_COOKIE, $cookie);
			}
			curl_multi_add_handle($mh,$handles[$key]);
		}
		$running=null;
        do{
            curl_multi_exec($mh,$running);
            usleep(500);
        } while ($running > 0);
        $result=array();
        foreach($urls as $key=>$url) {
            $result[$key]=curl_multi_getcontent($handles[$key]);
            curl_multi_remove_handle($mh,$handles[$key]);
        }
        curl_multi_close($mh);
        return $result;
	}
}