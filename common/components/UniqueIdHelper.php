<?php

namespace common\components;

use Yii;
use yii\base\Component;

/**
 * UniqueIdHelper
 */
 
class UniqueIdHelper extends Component
{
	public function init(){
		parent::init();
	}
	
	public static function generateItemCode()
	{
		$chars = "QWERTYUIOPASDFGHJKLZXCVBNM";
		$length = 4;
		$result = "";
		for($i=0; $i < $length; $i++){
			$result .= substr($chars, rand(0,strlen($chars)-1), 1);
		}
		return $result;
	}

	public static function generateUniqueId($prefix){
		$chars = "0123456789qwertyuiopasdfghjklzxcvbnm";
		$length = 8;
		$result = "";
		for($i=0; $i < $length; $i++){
			$result .= substr($chars, rand(0,strlen($chars)-1), 1);
		}
		return strtoupper($prefix.$result);
	}
}