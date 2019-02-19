<?php

class AGSVideoConvertor{
	public $ffmpegPath;
	public $audioSampleRate;
	public $audioBitrate;
	public $framesPerSecond;
	public $resizeVideo;
	public $resizeVideoWidth;
	public $resizeVideoHeight;
	public $tmpDir;
	public $file;
	public $log;
	function __construct($params){
		$this->ffmpegPath=$params['ffmpegPath'];
		$this->audioSampleRate=$params['audioSampleRate'];
		$this->audioBitrate=$params['audioBitrate'];
		$this->framesPerSecond=$params['framesPerSecond'];
		$this->resizeVideo=$params['resizeVideo'];
		$this->resizeVideoWidth=$params['resizeVideoWidth'];
		$this->resizeVideoHeight=$params['resizeVideoHeight'];
		$this->videoThumbWidth=$params['videoThumbWidth'];
		$this->videoThumbHeight=$params['videoThumbHeight'];
		$this->tmpDir=$params['tmpDir'];
		$this->log=array();
	}
	public function load($file){
		$this->file=$file;
		$this->video=array();
		$this->video['cmd']=$this->ffmpegPath.' -i '.$this->file;
		exec(escapeshellcmd($this->video['cmd']).' 2>&1', $output, $return);
		foreach($output as $line){
			if(!isset($this->video['bitrate']) && strstr($line, 'Duration:')){
				$parts=explode(', ', trim($line));
				$this->video['duration_timecode']=ltrim($parts['0'], 'Duration: ');
				$this->video['duration_seconds']=$this->timeToSeconds($this->video['duration_timecode']);
				$this->video['start']=ltrim($parts['1'], 'start: ');
				$this->video['bitrate']=(float)ltrim($parts['2'], 'bitrate: ');
				continue;
			}

			if(!isset($this->video['format']) && preg_match('/Stream(.*): Video: (.*)/', $line, $matches)){
				$parts=explode(', ', trim($matches['2']));
				$this->video['format']=$parts['0'];
				$this->video['colorspace']=$parts['1'];
				$dimension_string=$parts['2'];
				$this->video['framerate']=(float)$parts['3'];

				if(preg_match('/([0-9\.]+) (fps|tb)\(r\)/', $matches['2'], $fps_matches)){
					$this->video['framerate']=floatval($fps_matches['1']);
				}

				continue;
			}

			if(!isset($this->video['audio']) && preg_match('/Stream(.*): Audio: (.*)/', $line, $matches)){
				$parts=explode(', ', trim($matches['2']));
				$this->video['audio']=$parts['0'];
				$this->video['audio_frequency']=(float)$parts['1'];
				$this->video['audio_stereo']=$parts['2'];
				$this->video['audio_bitrate']=(isset($parts['3'])) ? (float)$parts['3'] : NULL;
				continue;
			}

			if(isset($this->video['bitrate']) && isset($this->video['format']) && isset($this->video['audio'])){
				break;
			}
		}

		if(isset($this->video['duration_seconds']) && isset($this->video['framerate'])){
			$this->video['frames']=ceil($this->video['duration_seconds'] * $this->video['framerate']);
		}

		if(isset($dimension_string)){
			if(preg_match('/([0-9]{1,5})x([0-9]{1,5})/', $dimension_string, $matches)){
				$this->video['width']=$matches['1'];
				$this->video['height']=$matches['2'];
				$ratios=(isset($matches['3'])) ? explode(' ', $matches['3']) : array();
				if(count($ratios) == 4){
					$this->video['aspect_ratio']=$ratios['3'];
					$this->video['aspect_ratio_pixel']=$ratios['1'];
				}
			}

			if(preg_match('/\[PAR ([0-9\:\.]+) DAR ([0-9\:\.]+)\]/', $dimension_string, $matches)){
				if(count($matches)){
					$this->video['par']=$matches['1'];
					$par=explode(':', $matches['1']);
					$this->video['par_float']=$par['0'] / $par['1'];
					$this->video['dar']=$matches['2'];
					$dar=explode(':', $matches['2']);
					$this->video['dar_float']=$dar['0'] / $dar['1'];
				}
			}else{
				// now this is PURE FUCKING testing
				if(round($this->video['width'] / $this->video['height']) == round(16 / 9)){
					$this->video['dar']='16:9';
					$this->video['dar_float']=16 / 9;
				}else{
					$this->video['dar']='4:3';
					$this->video['dar_float']=4 / 3;
				}
			}
		}

		return TRUE;
	}

	public function toFlv($src, $dst){
		return $this->toFlvFfmpeg($src, $dst);
	}

	private function toFlvFfmpeg($src, $dst){
		$options='-ar '.$this->audioSampleRate.' -ab '.$this->audioBitrate.' -f flv -acodec libmp3lame
		              -r '.$this->framesPerSecond.' -qmin 3 -qmax 6';
		if($this->resizeVideo){
			$options .= ' -s '.$this->resizeVideoWidth.'x'.$this->resizeVideoHeight;
		}else{
			$options .= ' -s '.$this->video['width'].'x'.$this->video['height'];
		}
		$cmd=$this->ffmpegPath.' -i '.$src.' -y '.$options.' '.$dst;
		$this->log[]=$cmd;
		exec(escapeshellcmd($cmd).' 2>&1', $output);
		$this->log[]=$output;
		if(file_exists($dst) && filesize($dst) > 1000){
			return TRUE;
		}

		return FALSE;
	}

	public function toMp4($src, $dst){
		exit('not implemented yet');
		$function='convert_to_mp4_'.$this->cfg['convert_mp4'];

		return $this->$function($src, $dst, $log_file);
	}

	public function toMp4Ffmpeg($src, $dst){
		exit('not implemented yet');
		// dont convert if resize set to no and video width < hd_min_width
		if($this->vcfg['hd_resize'] == '0'){
			if($this->video['width'] < $this->cfg['hd_min_width'] OR
				$this->video['height'] < $this->cfg['hd_min_height']){
				return FALSE;
			}
		}

		$options='-acodec libfaac -ab 96k -keyint_min 20 -vcodec libx264 -vpre '.SLOW_PRESET.' -crf 22 -threads 0';

//		if (isset($this->video['dar_float']) && $this->video['dar_float'] > 0) {
//			if (round($this->video['height'] * $this->video['dar_float']) > (1.01 * $this->video['width']) OR
//			    round($this->video['height'] * $this->video['dar_float']) < (0.99 * $this->video['width'])) {
//				$this->video['width'] = round($this->video['height'] * $this->video['dar_float']);
//			}
//		}

		if($this->vcfg['hd_resize'] == '1'){
			$width=$this->vcfg['hd_width'];
			$height=$this->vcfg['hd_height'];
		}elseif($this->vcfg['hd_resize'] == '2' && (isset($this->video['width']) && isset($this->video['height']))){
			$dimensions=$this->get_size($this->video['width'], $this->video['height']);
			$width=$dimensions['width'];
			$height=$dimensions['height'];
		}

		if(isset($width) && isset($height)){
			$options .= ' -s '.$width.'x'.$height;
		}

		$aspect='4:3';
		if(isset($this->video['dar_float'])){
			if(($this->video['dar_float'] >= 16 / 9 * 0.95) OR
				($this->video['dar_float'] === 0 && (($this->video['width'] / $this->video['height']) >= 16 / 9 * 0.95))){
				$aspect='16:9';
			}
		}
		$options .= ' -aspect '.$aspect;

//		$bitrate	 = $this->vcfg['hd_bitrate'];
//		if ($this->vcfg['hd_bitrate_method'] == 'auto' && isset($width) && isset($height)) {
//			$bitrate = $this->get_bitrate($width, $height);
//		}
//		$options    .= ' -b '.$bitrate;

		$cmd=$this->ffmpegPath.' -i '.$src.' -y '.$options.' '.$dst;
		$this->log($log_file, "\n".$cmd."\n");
		exec(escapeshellcmd($cmd).' 2>&1', $output);
		$this->log($log_file, "\n".implode("\n", $output));

		if(file_exists($dst) && filesize($dst) > 1000){
			return TRUE;
		}

		return FALSE;
	}

	public function extractThumbs($targetDir, $numberOfThumbs, $frames=array()){
		if(file_exists($this->file)==false){
			return FALSE;
		}else{
			if(empty($frames)==true){
				$frames=$this->generateFrames($this->video['duration_seconds'],$numberOfThumbs);
			}

			$i=1;
			$size=$this->videoThumbWidth.'x'.$this->videoThumbHeight;
			foreach($frames as $key=>$seconds){
				$cmd=$this->ffmpegPath.' -ss '.escapeshellarg($seconds).' -i '.escapeshellarg($this->file).' -f image2  -s '.escapeshellarg($size).' -vframes 2 -y '.escapeshellarg($targetDir.$i.'.jpg');
				$this->log[]=$cmd;
				exec(escapeshellcmd($cmd).' 2>&1', $output);
				$this->log[]=$output;
				$i=$i+1;
			}
			return $i-1;
		}
	}

	public function generateFrames($duration, $numberOfThumbs=1){
		$frames=array();
		$step=floor($duration / $numberOfThumbs);
		if($step <= 0){
			$step=1;
		}
		$i=1;
		while($i <= $numberOfThumbs and $i*$step<=$duration){
			$frames[]=$i * $step;
			++$i;
		}
		return $frames;
	}

	public function update_meta($src, $dst, $log_file, $no_logging=false){
		if(!file_exists($this->vcfg['yamdi_path'])){
			return FALSE;
		}

		$version=VF::cfg('library.version');
		$creator=$version['name'].'-'.$version['major'].'.'.$version['minor'];
		$cmd=$this->vcfg['yamdi_path'].' -i '.$src.' -o '.$dst.' -c '.$creator;
		$this->log($log_file, $cmd."\n", $no_logging);
		exec(escapeshellcmd($cmd).' 2>&1', $output);
		$this->log($log_file, "\n".implode("\n", $output), $no_logging);

		if(file_exists($dst) && filesize($dst) > 1000){
			unlink($src);
			return TRUE;
		}

		return FALSE;
	}

	private function get_size($width, $height){
		$dimensions=array();

		if($width <= $this->cfg['hd_width'] && $height <= $this->cfg['hd_height']){
			$dimensions['width']=$width;
			$dimensions['height']=$height;
		}elseif($this->cfg['hd_width'] / $width < $this->cfg['hd_height'] / $height){
			$dimensions['width']=$this->cfg['hd_width'];
			$dimensions['height']=round($height * $this->cfg['hd_width'] / $width);
		}else{
			$dimensions['width']=round($width * $this->cfg['hd_height'] / $height);
			$dimensions['height']=$this->cfg['hd_height'];
		}

		return $dimensions;
	}

	private function get_bitrate($width, $height){
		return 1500;
		$area=$width * $height;
		$hd_area=$this->cfg['hd_width'] * $this->cfg['hd_height'];
		return round((1 / 2 * $area / $hd_area + 1 / 2 * sqrt($area / $hd_area)) * $this->cfg['hd_bitrate']);
	}


	protected function timeToSeconds($timecode){
        $hours_end  = strpos($timecode, ':', 0);
        $hours      = substr($timecode, 0, $hours_end);
        $mins       = substr($timecode, $hours_end+1, 2);
        $secs       = trim(substr($timecode, $hours_end+4));
		if ($secs == '') {
			$mins 	= $hours;
			$secs 	= $mins;
			$hours 	= 0;
		}
        return ($hours*3600) + ($mins*60) + $secs;
	}

}