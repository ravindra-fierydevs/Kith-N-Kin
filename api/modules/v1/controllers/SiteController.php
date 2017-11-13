<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\helpers\Url;
use api\common\components\BaseController;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;
use yii\web\ServerErrorHttpException;

use common\models\User;
use common\models\Table;
use common\models\Order;
use common\models\OrderKot;
use common\models\OrderItem;
use common\models\SpecialNote;
use common\models\OrderItemSpecialNote;
use common\models\FoodItem;
use common\models\ChangePassword;
use common\models\UploadForm;

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

    
    public function actionUploadPic()
    {
        $uploadForm = new UploadForm();
        $file = \yii\web\UploadedFile::getInstance($uploadForm, 'imageFile');
        $uploadForm->imageFile = $file;
        $fileName = $uploadForm->imageFile->baseName."_".time().'.'.$uploadForm->imageFile->extension;

        if($uploadForm->imageFile->saveAs('uploads/' . $fileName))
        {
            return ['success' => 'true', 'url' => 'http://192.168.0.222:84/Kith-N-Kin/api/web/uploads/' . $fileName];
        }

        throw new ServerErrorHttpException('Something went wrong. Please try again after some time.');
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

        throw new UnauthorizedHttpException("User is not registered");
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
        //$special_notes = explode(',', $special_notes);
        $special_notes = array_map('trim', explode(',', $special_notes));

        if(!$type){
            throw new BadRequestHttpException("Type cannot be left blank");
        }

        if(!$food_item_id){
            throw new BadRequestHttpException("Food item id cannot be left blank");
        }

        if(!$quantity){
            throw new BadRequestHttpException("Quantity cannot be left blank");
        }

        if($type == Order::TYPE_TABLE_ORDER){
        	if(!$table_id){
        		throw new BadRequestHttpException("Table id cannot be left blank when type is 1");
        	}
        }

        $foodItemModel = FoodItem::findOne($food_item_id);
        if(!$foodItemModel){
        	throw new BadRequestHttpException("Food Item Id is not valid or has been deleted");
		}

        $order = new Order();
        $kot = new OrderKot();
        $order_item = new OrderItem();

        $order->type = $type;
        if($type == Order::TYPE_TABLE_ORDER){
        	$order->table_id = $table_id;
        }

        $order->current_status = Order::STATUS_IN_PROGRESS;
        $order->created_by = $user->id;
        $order->updated_by = $user->id;

        if($order->validate()){
        	if($order->save()){
        		$kot->order_id = $order->id;
        		$kot->current_status = OrderKot::KOT_RECEIVED;
        		if($kot->save()){
        			$order_item->order_id = $kot->order_id;
        			$order_item->order_kot_id = $kot->id;

        			$order_item->food_item_id = $foodItemModel->id;
        			$order_item->quantity = $quantity;
        			$order_item->price_each = $foodItemModel->price;
        			$order_item->price_total = $foodItemModel->price * $quantity;
        			if($order_item->save()){
	        			foreach ($special_notes as $sp) {
	        				$orderItemSpecialNote = new OrderItemSpecialNote();
	        				$orderItemSpecialNote->special_note_id = $sp; 
	        				$orderItemSpecialNote->order_item_id = $order_item->id;
	        				$orderItemSpecialNote->save();
	        			}

	        			return ['success' => true, 'order' => $order, 'kot' => $kot, 'order', 'order_item' => $order_item];
        			}
        			throw new ServerErrorHttpException('Something went wrong. Please try again after some time.');
        		}
        		throw new ServerErrorHttpException('Something went wrong. Please try again after some time.');
        	}
        	throw new ServerErrorHttpException('Something went wrong. Please try again after some time.');
        }

        return [
			"name" => "Bad Request",
			"message" => $order->getErrors(),
			"code" => 0,
			"status" => 400,
			"type" => "yii\web\BadRequestHttpException"
		];

    }

    public function actionAddFoodItem()
    {
        $kot_id = Yii::$app->request->post('kot_id');
        $food_item_id = Yii::$app->request->post('food_item_id');
        $quantity = Yii::$app->request->post('quantity');
        $special_notes = Yii::$app->request->post('special_notes');
        $special_notes = array_map('trim', explode(',', $special_notes));

        if(!$kot_id){
            throw new BadRequestHttpException("Kot id cannot be left blank");
        }

        if(!$food_item_id){
            throw new BadRequestHttpException("Food item id cannot be left blank");
        }

        if(!$quantity){
            throw new BadRequestHttpException("Quantity cannot be left blank");
        }

        $kotModel = OrderKot::findOne($kot_id);

        if(!$kotModel){
            throw new BadRequestHttpException("Kot id is invalid");
        }

        $this->validateKot($kotModel);

        $foodItemModel = FoodItem::findOne($food_item_id);

        if(!$foodItemModel){
            throw new BadRequestHttpException("Food Item Id is not valid or has been deleted");
        }

        $orderItem = new OrderItem();
        $orderItem->order_id = $kotModel->order->id;
        $orderItem->order_kot_id = $kotModel->id;
        $orderItem->food_item_id = $foodItemModel->id;
        $orderItem->quantity = $quantity;
        $orderItem->price_each = $foodItemModel->price;
        $orderItem->price_total = $foodItemModel->price * $quantity;
        if($orderItem->save()){
            foreach ($special_notes as $sp) {
                $orderItemSpecialNote = new OrderItemSpecialNote();
                $orderItemSpecialNote->special_note_id = $sp;
                $orderItemSpecialNote->order_item_id = $orderItem->id;
                $orderItemSpecialNote->save();
            }
        }

        return $this->successResponse($orderItem);
    }
}