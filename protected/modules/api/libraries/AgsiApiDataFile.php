<?php

class AgsiApiDataFile {

	function makeFile(&$dataReader = null, &$array = null) {
		if (isset($dataReader) or isset($array)) {
			$trace = debug_backtrace();
			if (isset($trace[1])) {

				$callerString = $trace[1]['function'];
				if (isset($trace[1]['class'])) {
					$callerString = crc32($trace[1]['class'] . '::' . $callerString);
				} else {
					$callerString = crc32($callerString);
				}
			} else {
				$callerString = '';
			}
			$fileName = $callerString . '-' . rand(0, 999999) . '.txt';
			$filePath = dirname(__FILE__) . '/../../../../apiDataFiles' . $fileName;
			$fileHandle = fopen($filePath, 'w+');
			if ($fileHandle) {
				if (isset($dataReader)) {
					while (($row = $dataReader->read()) !== false) {
						fwrite($fileHandle, serialize($row) . "\n");
					}
				} elseif (isset($array)) {
					$max = count($array);
					for ($i = 0; $i < $max; $i++) {
						fwrite($fileHandle, serialize($max[$i]) . "\n");
					}
				}
				fclose($fileHandle);
				exec('gzip -f ' . $filePath);
				if (is_file($filePath . '.gz')) {
					return Yii::app()->params['baseUrl'] . '/apiDataFiles/' . $fileName . '.gz';
				} else {
					Yii::log('Failed to gzip file "' . $filePath . '".Removing file.', 'error', __CLASS__);
					unlink($filePath);
				}
			} else {
				Yii::log('Failed to open file "' . $filePath . '" for writing.', 'error', __CLASS__);
			}
		} else {
			Yii::log('No data source received', 'error', __CLASS__);
		}
		return false;
	}

	function getFile($fileUrl) {
		Yii::import('ext.crawlers.libraries.BCurl');
		$bCurl = new BCurl();
		$fileName = trim($fileUrl, '/');
		$fileName = substr($fileName, strrpos($fileName, '/'));
		$filePath = realpath(dirname(__FILE__) . '/../../../runtime/tmp/downloads') . $fileName;
		if ($bCurl->file($fileUrl, $filePath)) {
			if (is_file($filePath)) {
				exec('gunzip -f ' . $filePath);
				$filePath = substr($filePath, 0, strlen($filePath) - 3);
				if (is_file($filePath)) {
					return $filePath;
				} else {
					Yii::log('Failed to gunzip file "' . $filePath . '.gz"', 'error', __CLASS__);
				}

			} else {
				Yii::log('Could not find downloaded file. The file path is "' . $filePath . '"', 'error', __CLASS__);
			}
		} else {
			Yii::log('Could not download file to import videos. The url used is "' . $fileUrl . '"', 'error', __CLASS__);
		}
	}

}

?>
