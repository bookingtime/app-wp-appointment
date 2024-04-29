<?php

namespace bookingtime\phpsdkapp\Lib;
use Symfony\Component\Form\FormInterface;



/**
 * base function-library of bookingtime for static use
 *
 * @author DKone <bookingtime GmbH>
 */
class BasicLib {



	/*******************************************************************
	 *
	 * MISC FUNCTIONS
	 *
	 *******************************************************************/
	/**
	 * check if string contains JSON
	 *
	 * @param	string		$string: check this tring
	 * @return	boolean		TRUE if string is json
	 */
	public static function isJSON($string):bool {
		return (((is_string($string) && (is_object(json_decode($string)) || is_array(json_decode($string)))))?TRUE:FALSE);
	}



	/**
	 * return a gernerated random hash, usfull for tokens,captcha and so on...
	 * INFO: case-sensitive alphnum hash [0-9a-zA-Z]
	 *
	 * @param	integer		$length: count of random chars - optional
	 * @return	string
	 */
	public static function getRandomHash($length=6):string {
		$hash='';
		$chars='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		for($i=0;$i<$length;$i++) {$hash.=$chars[random_int(0,strlen($chars)-1)];}
		return $hash;
	}



	/**
	 * check submitted var for type of 'string|integer|float|boolean|object'
	 * NOTE: function throws exception if type is mismatching the var-type
	 *
	 * @param	string		$type: expected type of submitted parameter
	 * @param	string		$var: the parameter itself as reference
	 * @param	string		$varName: name of parameter
	 * @return	void
	 */
	public static function checkType($type,&$var,$varName):void {
		//check submitted parameters
		if(empty($type)) {throw new \InvalidArgumentException(__METHOD__.'() #'.__LINE__.': No type submitted!');}
		if(empty($varName)) {throw new \InvalidArgumentException(__METHOD__.'() #'.__LINE__.': No varName submitted!');}
		if(!is_string($varName)) {throw new \InvalidArgumentException(__METHOD__.'() #'.__LINE__.': varName is no string!');}

		//type of var is valid
		switch($type) {
			default: {
				throw new \InvalidArgumentException(__METHOD__.'() #'.__LINE__.': Var of invalid type submitted! Allowed types are string|integer|float|boolean|object');
			} case('string'): {
				if(is_string($var)) {return;}
				break(1);
			} case('integer'): {
				if(is_int($var)) {return;}
				break(1);
			} case('float'): {
				if(is_float($var)) {return;}
				break(1);
			} case('boolean'): {
				if(is_bool($var)) {return;}
				break(1);
			} case('object'): {
				if(is_object($var)) {return;}
				break(1);
			}
		}

		//get type and content of var for exception message
		if(is_array($var)) {
			$submittedType='array';
		} elseif(is_object($var)) {
			$submittedType='object';
		} elseif(is_null($var)) {
			$submittedType='NULL';
		} elseif(is_bool($var)) {
			$submittedType='boolean';
		} elseif(is_string($var)) {
			$submittedType='string';
		} elseif(is_int($var)) {
			$submittedType='integer';
		} elseif(is_float($var)) {
			$submittedType='float';
		} elseif(is_resource($var)) {
			$submittedType='resource';
		} else {
			$submittedType='unknown';
		}
		$content=($submittedType!='unknown'?self::debugVar($var,TRUE,"   "):'');

		//create trace
		$traceContent='';
		$traceArray=debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,9);
		#die(BasicLib::debug($traceArray));
		if(is_array($traceArray)) {
			foreach($traceArray as $item) {
				$file=trim($item['file']);
				$line=intval($item['line']);
				$class=trim($item['class']);
				$className=substr($class,(strrpos($class,'\\')+1));
				$method=trim($item['function']);
				$traceContent.=$file.' (#'.$line.') '.$className.$item['type'].$method.'()'."\n";
			}
		}

		//throw exception
		throw new \InvalidArgumentException(__METHOD__.'() #'.__LINE__.': '.$varName.': '.$type.' expected! Submitted var is of type: '.$submittedType."\n".'content: '.substr($content,0,99).' / trace:'."\n".$traceContent);
	}



	/*******************************************************************
	 *
	 * DEBUG/ERROR FUNCTIONS
	 *
	 *******************************************************************/
	/**
	 * debug a nice looking variable in HTML format
	 * INFO: only dump if self::debug is true
	 *
	 * @param	array			$var: debug this vars
	 * @return	string		html formated
	 */
	public static function debug(...$varArray):string {
		//only dump if APP environment is set and not stage or prod
		if(isset($_SERVER) && is_array($_SERVER) && array_key_exists('APP_ENV',$_SERVER) && in_array($_SERVER['APP_ENV'],['stage','prod'],TRUE)) {return '';}

		//make meta data
		$tmp=debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,2);
		if(!empty($tmp) && is_array($tmp) && count($tmp)===2) {
			$file=trim($tmp[0]['file']);
			$class=trim($tmp[1]['class']);
			$className=substr($class,(strrpos($class,'\\')+1));
			$method=trim($tmp[1]['function']);
			$line=intval($tmp[0]['line']);
			$headline=($class?$class.'::':'').($method?$method.'() ':'').($line?'#'.$line.' ':'');
			$label='';
		} else {
			$file='';
			$class='';
			$className='';
			$method='';
			$line=0;
			$label='';
		}

		//check for optional label
		if(count($varArray)===2 && is_string($varArray[0]) && strlen($varArray[0])>0 && strlen($varArray[0])<100) {
			$label=trim($varArray[0]);
			unset($varArray[0]);
		}

		//make content
		$contentArray=[];
		foreach($varArray as $var) {
			$content=self::debugVar($var);
			$contentArray[]='<pre class="debug">'.trim($headline).' -> '.trim($content).'</pre>';
		}
		return implode("\n",$contentArray)."\n\n";
	}



	/**
	 * get a well formated variable with var_dump() for debug
	 *
	 * @param	mixed		$var:format this var
	 * @param	boolean	$short:short format, without type of variable
	 * @param	string	$space:put some space/tabs before arrays
	 * @return	string   dump variable
	 */
	public static function debugVar($var,$short=FALSE,$space=''):string {
		if($short) {
			if(is_array($var)) {
				if(!empty($var)) {
					$content='array('."\n";
					foreach($var as $key=>&$value) {$content.="  ".$space.'['.$key.']=>'.self::debugVar($value,$short,"  ".$space)."\n";}
					unset($value);
					$content.=$space.')';
				} else {
					$content='[]';
				}
			} elseif(is_object($var) && $var instanceof \Doctrine\Common\Collections\Collection) {
				if(!$var->isEmpty()) {
					$content=get_class($var).'('."\n";
					foreach($var as $key=>&$value) {$content.="  ".$space.'['.$key.']=>'.self::debugVar($value,$short,"  ".$space)."\n";}
					unset($value);
					$content.=$space.')';
				} else {
					$content=get_class($var).'(0) {}';
				}
			} elseif(is_object($var) && method_exists($var,'getLogInfo')) {
				$content=$var->getLogInfo();
			} elseif(is_object($var) && is_a($var,'DateTime')) {
				$content=$var->format('d.m.Y H:i:s e');
			} elseif(is_object($var)) {
				$content=get_class($var);
			} elseif(is_bool($var)) {
				$content=($var?'TRUE':'FALSE');
			} elseif(is_null($var)) {
				$content='NULL';
			} elseif(is_resource($var)) {
				ob_start();
				var_dump($var);
				$content=trim(ob_get_contents());
				ob_end_clean();
			} else {
				$content=trim($var);
			}
		} else {
			if(is_array($var)) {
				if(!empty($var)) {
					$content='array('.count($var).') {'."\n";
					foreach($var as $key=>&$value) {$content.="   ".$space.'['.(is_string($key)?'"'.$key.'"':$key).'] => '.self::debugVar($value,$short,"   ".$space)."\n";}
					$content.=$space.'}';
				} else {
					$content='array(0) {}';
				}
			} elseif(is_object($var) && $var instanceof \Doctrine\Common\Collections\Collection) {
				if(!$var->isEmpty()) {
					$content=get_class($var).'('.$var->count().') {'."\n";
					foreach($var as $key=>&$value) {$content.="   ".$space.'['.$key.'] => '.self::debugVar($value,$short,"   ".$space)."\n";}
					$content.=$space.'}';
				} else {
					$content=get_class($var).'(0) {}';
				}
			} elseif(is_object($var) && method_exists($var,'getLogInfo')) {
				$content='object('.get_class($var).') '.$var->getLogInfo();
			} elseif(is_object($var) && is_a($var,'DateTime')) {
				$content='dateTime('.$var->format('d.m.Y H:i:s.u e').')';
			} elseif(is_object($var)) {
				$content='object('.get_class($var).')';
			} else {
				ob_start();
				var_dump($var);
				$content=trim(ob_get_contents());
				ob_end_clean();
			}
		}
		return $content;
	}
}
