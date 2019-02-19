<?php
error_reporting(E_ALL & ~E_NOTICE);
set_time_limit(0);
class ImportVideosFromFileCommand extends CConsoleCommand {

	public function run($args) {
		$filePath=$args[0];
		if (is_file($filePath)) {
			exec('gunzip -f ' . $filePath);
			$filePath = substr($filePath, 0, strlen($filePath) - 3);
			if (is_file($filePath)) {
				$errors = 0;
				$fileHandle = fopen($filePath, 'r');
				$videoModel = new Video();
				if ($fileHandle) {
					$videoCounter=0;
					while (($buffer = fgets($fileHandle, 4096)) !== false and $errors < 100) {
						$data = @unserialize($buffer);
						if ($data != false) {
//								echo 'se face importul la videoclipul '.$data['title'].PHP_EOL;
							$videoModel->add_video($data,false);
						} else {
							$errors = $errors + 1;
						}
						if($videoCounter%1000==0){
							sleep(1);
						}
						$videoCounter=$videoCounter+1;
					}
					if ($errors >= 100) {
						Yii::log('Too many errors while unserializing data from the downloaded file. The url used is "' . $_POST['fileUrl'] . '"', 'error', __CLASS__);
					} 
					fclose($fileHandle);
					unlink($filePath);
				} else {
					Yii::log('Could not open file "' . $filePath . '"', 'error', __CLASS__);
				}
			} else {
				Yii::log('Failed to gunzip file "' . $filePath . '".gz', 'error', __CLASS__);
			}
		} else {
			Yii::log('Could not find downloaded file. The file path is "' . $filePath . '"', 'error', __CLASS__);
		}
	}

}

?>
