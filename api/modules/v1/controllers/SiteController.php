<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\helpers\Url;
use api\common\components\BaseController;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;

use common\models\User;
use common\models\Table;
use common\models\Order;
use common\models\OrderKot;
use common\models\SpecialNote;
use common\models\FoodItem;
use common\models\ChangePassword;
/********
Site Controller API
@author Featsystems <ravindra.chavan@featsystems.com>
*********/

class SiteController extends BaseController
{
	public $modelClass = 'common\models\User';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function behaviors() {
        $behaviors = parent::behaviors();
        
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        return $actions;
    }

    public function actionLogin()
    {
        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');
        if(!$username){
            throw new BadRequestHttpException("Username cannot be left blank");
        }
        if(!$password){
            throw new BadRequestHttpException("Password cannot be left blank");
        }

        $user = User::find()->where(['username' => $username])->asArray()->one();

        unset($user['password_hash']);
        unset($user['password_reset_token']);

        if($user){
            $result = ['success' => 'true', 'data' => $user];
            return $result;
        }
        $result = ['error' => 'true', 'message' => 'User is not registered'];
        return $result;
        //throw new UnauthorizedHttpException("User is not registered");
    }

    public function actionViewProfile()
    {
        $user = $this->checkAuth();
        return $user->empDetail;
    }

    public function actionChangePassword()
    {
        $user = $this->checkAuth();
        $model = new ChangePassword();
        $old_password = Yii::$app->request->post('old_password');
        $new_password = Yii::$app->request->post('new_password');
        $new_password_confirm = Yii::$app->request->post('new_password_confirm');

        if(!$old_password){
            throw new BadRequestHttpException("Old password cannot be left blank");
        }

        if(!$new_password){
            throw new BadRequestHttpException("New password cannot be left blank");
        }

        if(!$new_password_confirm){
            throw new BadRequestHttpException("New password confirm cannot be left blank");
        }

        if($new_password != $new_password_confirm)
        {
            throw new BadRequestHttpException("New password and new password confirm does not match");
        }

        if($model->validateAppPass($old_password, $user->id)){
            $user->setPassword($new_password);
            return $this->successResponse("Password changed successfully");
        }

        return $this->errorResponse("Old password is wrong");
    }

    public function actionGetTables()
    {
    	$user = $this->checkAuth();
    	$model = Table::find()->all();
    	return $model;
    }

    public function actionGetMenu()
    {
    	$user = $this->checkAuth();
    	$model = FoodItem::find()->all();
    	return $model;
    }

    public function actionGetOrderTypes()
    {
    	$user = $this->checkAuth();
    	$types = Order::$types;
    	return $types;
    }

    public function actionGetOrderStatuses()
    {
    	$user = $this->checkAuth();
    	$statuses = Order::$statuses;
    	return $statuses;
    }

    public function actionGetKotStatuses()
    {
    	$user = $this->checkAuth();
    	$kot_statuses = OrderKot::$kot_statuses;
    	return $kot_statuses;
    }

    public function actionGetSpecialNotes()
    {
    	$user = $this->checkAuth();
    	$model = SpecialNote::find()->all();
    	return $model;
    }

    public function actionCreateOrder()
    {
    	$user = $this->checkAuth();
    	$type = Yii::$app->request->post('type');
        $table_id = Yii::$app->request->post('table_id');
        $food_item_id = Yii::$app->request->post('food_item_id');
        $quantity = Yii::$app->request->post('quantity');
        $special_notes = Yii::$app->request->post('special_notes');

        if(!$type){
            throw new BadRequestHttpException("Type cannot be left blank");
        }

        if(!$food_item_id){
            throw new BadRequestHttpException("Food item id cannot be left blank");
        }

        if(!$quantity){
            throw new BadRequestHttpException("Quantity cannot be left blank");
        }

        return "validation successful";
    }
}