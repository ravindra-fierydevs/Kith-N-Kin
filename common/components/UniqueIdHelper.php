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
}