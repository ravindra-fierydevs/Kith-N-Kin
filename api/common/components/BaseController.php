<?php

namespace api\common\components;

use Yii;
use common\models\User;
use yii\rest\ActiveController;

use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;

class BaseController extends ActiveController
{
	public function init(){
		parent::init();
	}

	protected function checkAuth(){
		$auth_key = Yii::$app->request->post("auth_key");
		if(!$auth_key){
			throw new BadRequestHttpException("User Auth Key is missing.");
		}
		$user = User::findByAuthKey($auth_key);
		if(!$user){
			throw new UnauthorizedHttpException("User is not registered.");
		}
		return $user;
	}

	protected function successResponse($data)
	{
		return ['success' => 'true', 'data' => $data];
	}

	protected function errorResponse($msg)
	{
		return ['error' => 'true', 'message' => $msg];
	}
}