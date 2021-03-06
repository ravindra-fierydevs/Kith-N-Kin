<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order_kot_status".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $order_kot_id
 * @property integer $kot_status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Order $order
 * @property OrderKot $orderKot
 */
class OrderKotStatus extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'order_kot_status';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            [['order_id', 'order_kot_id', 'kot_status', 'created_at', 'updated_at'], 'integer'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['order_kot_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrderKot::className(), 'targetAttribute' => ['order_kot_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'order_kot_id' => 'Order Kot ID',
            'kot_status' => 'Kot Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    public function getOrderKot()
    {
        return $this->hasOne(OrderKot::className(), ['id' => 'order_kot_id']);
    }
}
