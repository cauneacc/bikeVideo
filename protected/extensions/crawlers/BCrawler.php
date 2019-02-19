<?php
Yii::import('ext.crawlers.libraries.BCurl');
class BCrawler {
    protected $videosPublished = 0;

    public function add_video($video, $automaticChangeTitle=true) {
		$videoModel=new Video();
		$r=$videoModel->add_video($video, $automaticChangeTitle);
		if($r==true){
			$this->videosPublished=$this->videosPublished+1;
		}
		return $r;
    }
	protected function clean_html($html){
		$html=str_replace(array("\n", "\r"), '', $html);
		$html=preg_replace('/\s\s+/', ' ', $html);
		return $html;
	}

    protected function manageMessages($message, $variables=null, $level='info') {
        if ($level == 'error') {
            $aux = Yii::t('BCrawlers', $message, $variables);
            Yii::log($aux, 'error', 'extensions.crawlers');
            $this->errors[] = $aux;
        } else {
            Yii::log(Yii::t('BCrawlers', $message, $variables), 'info', 'extensions.crawlers');
        }
    }


    function __destruct() {
        $filename = Yii::getPathOfAlias('application.runtime.crawlers');
        return file_put_contents($filename . DIRECTORY_SEPARATOR . $this->identifier, time() . ';' . $this->videosGrabbed . ';' . $this->videosSkipped . ';' . $this->videosPublished . ';');
    }

    public static function getLastRunSummary($identifier) {
        $file = Yii::getPathOfAlias('application.runtime.crawlers') . DIRECTORY_SEPARATOR . $identifier;
        if (is_file($file) == true) {
            if (is_readable($file) == true) {
                $summary = file_get_contents($file);
                if ($summary) {
                    $summary = explode(';', $summary);
                    return array('time' => $summary[0], 'videosGrabbed' => $summary[1], 'videosSkipped' => $summary[2], 'videosPublished' => $summary[3]);
                } else {
                    return false;
                }
            } else {
                $this->manageMessages('Crawler summary file {file} is not readeable', array('{file}' => $file), 'error');
                return false;
            }
        } else {
            return false;
        }
    }

    public function addMultipleVideos($videos) {
		$videoModel=new Video();
		foreach($videos as $video){
			$videoModel->add_video($video, false);
		}
    }
    
    public function createFlashEmbedCode($videoFileUrl){
        return '<object id="player" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" name="player" width="{embedWidth}" height="{embedHeight}">
		<param name="movie" value="{themeBaseUrl}/swf/player.swf" />
		<param name="allowfullscreen" value="true" />
		<param name="allowscriptaccess" value="always" />
		<param name="flashvars" value="file='.$videoFileUrl.'" />
		<embed
			type="application/x-shockwave-flash"
			id="player2"
			name="player2"
			src="{themeBaseUrl}/swf/player.swf"
			width="{embedWidth}"
			height="{embedHeight}"
			allowscriptaccess="always"
			allowfullscreen="true"
			flashvars="file='.$videoFileUrl.'"
		/>
	</object>';
    }

	public function addEmbededVideos($videos){
		$videoModel=new Video();
		foreach($videos as $video){
			$r=$videoModel->add_video($video, false);
			if($r==true){
				$this->videosPublished=$this->videosPublished+1;
			}
		}
	}


}
