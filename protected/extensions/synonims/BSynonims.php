<?php

class BSynonims{

//require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'dict.php');
	private $d;

	public function __construct(){
		$dictionaryPath=Yii::getPathOfAlias('ext.synonims.dict').'.php';
		if(is_file($dictionaryPath) == true){
			if(is_readable($dictionaryPath) == true){
				$this->d=require_once($dictionaryPath);
			}
		}
	}

	public function changeTitle($t){
		if(count($this->d) > 0){
			$t=strtolower($t);
			$originalText=$t;
			$t=preg_replace("/[^a-z0-9\s]/", "", $t);
			$words=explode(' ', $t);
			$originalWords=explode(' ', $originalText);
			$synonims=array();
			foreach($words as $word){
				$synonims[]=array(0=>$word, 1=>$this->searchSynonims($word));
			}
			$max=count($synonims);
			foreach($originalWords as $key=>$originalWord){
				$i=0;
				while($i < $max){
					if($originalWord == $synonims[$i][0]){
						$originalWords[$key]=$synonims[$i][1];
						$i=$max;
					}
					$i=$i + 1;
				}
			}
			return ucfirst(implode(' ', $originalWords));
		}else{
			return $t;
		}
	}

	public function transformDictionaryInJavascript(){
		$javascriptArray='';
		foreach($this->d as $name=>$value){
			$javascriptArray=$javascriptArray.'\''.addslashes($name).'\':[';
			foreach($value as $innerValue){
				$javascriptArray=$javascriptArray.'\''.addslashes($innerValue).'\',';
			}
			$javascriptArray=substr($javascriptArray, 0, strlen($javascriptArray) - 1).'],';
		}
		$javascriptArray=substr($javascriptArray, 0, strlen($javascriptArray) - 1);
		return substr($javascriptArray, 1);
	}

	protected function searchSynonims($g){
		if($this->d[$g] == true){
			return $this->d[$g][rand(0, count($this->d[$g]) - 1)];
		}else{
			return $g;
		}
	}

//Not yet used
	protected function displayRotatedArrays($d){
		foreach($d as $key=>$value){
			if(count($value) == 1){
				echo '$d[\''.$value[0].'\']=array(\''.$key.'\');'."\n";
			}elseif(count($value) > 1){
				foreach($value as $val){
					echo '$d[\''.$val.'\']=array(\''.$key.'\'';
					foreach($value as $val1){
						if($val1 != $val){
							echo ',\''.$val1.'\'';
						}
					}
					echo ");\n";
				}
			}
		}
	}

	protected function prepareTags($text){
		$stopWords=array(' i ', ' a ', ' about ', ' an ', ' and ', ' are ', ' as ',
			' at ', ' be ', ' by ', ' for ', ' from ', ' how ', ' in ', ' is ', ' it ',
			' on ', ' or ', ' that ', ' the ', ' this ', ' to ', ' was ', ' what ',
			' when ', ' where ', ' who ', ' will ', ' with ', ' www ', ' his ', ' her ',
			' it ', ' el ');
		$text=str_replace($stopWords, ' ', $text);
		return htmlentities(strip_tags($text));
	}

	public function rotateTextWithBrackets($sentence){
		$startPosition=array();
		$endPosition=array();
		$max=strlen($sentence);
		$bracketArrayPosition=0;
		$bracketDepth=array();
		for($i=0; $i < $max; $i=$i + 1){
			if($sentence[$i] == '{'){
				$startPosition[]=$i;
				$bracketArrayPosition=$bracketArrayPosition + 1;
				$bracketDepth[]=$bracketArrayPosition;
			}
			if($sentence[$i] == '}'){
				$j=count($bracketDepth);
				while($j >= 0){
					if($bracketDepth[$j] == $bracketArrayPosition){
						$endPosition[$j]=$i;
						$j=-1;
					}
					$j=$j - 1;
				}
				$bracketArrayPosition=$bracketArrayPosition - 1;
			}
		}
		$savedStartPosition=$startPosition;
		$savedEndPosition=$endPosition;
		$savedBracketDepth=$bracketDepth;


//de aici se incepe inlocuirea variantelor
		$sentences=array($sentence);
		$words=array();
		$max=count($startPosition);
		if($max == count($endPosition)){
//	echo __FILE__.' '.__LINE__.'<pre>';
//	var_dump($bracketDepth);
//	echo '</pre>';
			do{
				$deepest=1;
				reset($bracketDepth);
				$positionOfDeepest=key($bracketDepth);
				foreach($bracketDepth as $i=>$depth){
					if($depth > $deepest){
						$deepest=$depth;
						$positionOfDeepest=$i;
					}
				}
				if($deepest > 1){
					$textToRotate=substr($sentence, $startPosition[$positionOfDeepest], $endPosition[$positionOfDeepest] - $startPosition[$positionOfDeepest] + 1);
					$textToRotate=trim($textToRotate, '{}');
					$contents=explode('|', $textToRotate);

					foreach($sentences as $sentence1){
						foreach($contents as $content){
							$padding=str_repeat(' ', strlen($textToRotate) + 2 - strlen($content));
							$sentences[]=str_replace('{'.$textToRotate.'}', $content.$padding, $sentence1);
						}
					}
					unset($startPosition[$positionOfDeepest]);
					unset($endPosition[$positionOfDeepest]);
					unset($bracketDepth[$positionOfDeepest]);
				}
			}while($deepest > 1);
			$deepestBracketPositions=array();
			$shallowBracketPositions=array();
			foreach($savedBracketDepth as $position=>$bracketDepth){
				if($bracketDepth > 1){
					$deepestBracketPositions[]=$position;
				}else{
					$shallowBracketPositions[]=$position;
				}
			}

//from here we clean the newly formed sentences so we are left only with the simple care {} without {{}}
			foreach($sentences as $key=>$sentence){
				foreach($deepestBracketPositions as $deepestBracketPosition){
					if(substr($sentence, $savedStartPosition[$deepestBracketPosition], 1) == '{'){
						unset($sentences[$key]);
					}
				}
			}
//create all the other cases
			$aux=array();
			foreach($sentences as $rawSentence){
				$newSentences=array($rawSentence);
				$i=0;
				while($i < count($newSentences)){
					foreach($shallowBracketPositions as $position=>$shallowBracketPosition){
						if(substr($newSentences[$i], $savedStartPosition[$shallowBracketPosition], 1) == '{' and
							substr($newSentences[$i], $savedEndPosition[$shallowBracketPosition], 1) == '}'){
							$textToRotate=substr($newSentences[$i], $savedStartPosition[$shallowBracketPosition], $savedEndPosition[$shallowBracketPosition] - $savedStartPosition[$shallowBracketPosition] + 1);
							$textToRotate=trim($textToRotate, '{}');
							$contents=explode('|', $textToRotate);
							foreach($contents as $content){
								$padding=str_repeat(' ', strlen($textToRotate) + 2 - strlen($content));
								$newSentences[]=str_replace('{'.$textToRotate.'}', $content.$padding, $newSentences[$i]);
							}
						}
					}
					$i=$i + 1;
				}

				$aux=array_merge($aux, $newSentences);
			}
			$max=count($aux);
			for($i=0; $i < $max; $i++){
				if(strpos($aux[$i], '{') !== false){
					unset($aux[$i]);
				}elseif(strpos($aux[$i], '{') !== false){
					unset($aux[$i]);
				}
			}
			return $aux;
		}else{
			return false;
		}
	}

}

?>
