<?php

class AgsiThemesHelper {

	function getAvailableThemes() {
		$themes = array();
		$dir = Yii::getPathOfAlias('webroot.themes');
		if (is_dir($dir) == true) {
			$dh = opendir($dir);
			if ($dh) {
				while (($file = readdir($dh)) !== false) {
					if ($file != '..' and $file != '.') {
						if ($dir . DIRECTORY_SEPARATOR . is_dir($file) == true) {
							if (is_file($dir . DIRECTORY_SEPARATOR . $file . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'style.css') == true) {
								$text = @file_get_contents($dir . DIRECTORY_SEPARATOR . $file . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'style.css');
								if ($text !== false) {
									$themeInformation = $this->parseThemeCssHeader($text);
									$themeInformation['agsThemeName'] = $file;
									$themeImagePreview = $this->getThemePreviewsUrl($file);
									if ($themeInformation != false) {
										$themes[] = array_merge($themeInformation, $themeImagePreview);
//										$this->availableThemes[] = $file;
									}
								}
							}
						}
					}
				}

				closedir($dh);
			}
		}
//		Yii::log(var_export($themes),'error');
		return $themes;
	}

	protected function parseThemeCssHeader($text) {
		$r = array();
		$start = strpos($text, '/*');
		if ($start !== false) {
			$end = strpos($text, '*/', $start + 2);
			if ($end != false) {
				$header = substr($text, $start + 2, $end - $start - 2);
				$rows = explode("\n", $header);
				if (count($rows) == 1) {
					$rows = explode("\r", $header);
				}
				$max = count($rows);
				for ($i = 0; $i < $max; $i++) {
					if (trim($rows[$i]) != '') {
						$rows[$i] = trim($rows[$i]);
						$end = strpos($rows[$i], ':');

						if ($end != false) {
							$r[str_replace(' ', '', substr($rows[$i], 0, $end))] = trim(substr($rows[$i], $end + 1));
						} else {
							$r['Comments'] = $r['Comments'] . $rows[$i];
						}
					}
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
		return $r;
	}

	protected function getThemePreviewsUrl($name) {
		$r = array();
		$themePreviewPath = Yii::getPathOfAlias('webroot.themes') . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'themePreview.jpg';
		$themePreviewThumbnailPath = Yii::getPathOfAlias('webroot.themes') . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'themePreviewThumbnail.jpg';
		if (is_file($themePreviewPath)) {
			$r['largePreview'] = 'themes/' . $name . '/images/themePreview.jpg';
		}
		if (is_file($themePreviewThumbnailPath)) {
			$r['thumbnailPreview'] ='themes/' . $name . '/images/themePreviewThumbnail.jpg';
		}
		return $r;
	}

}

?>
