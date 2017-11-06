<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "order_kot".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $current_status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property OrderItem[] $orderItems
 * @property Order $order
 * @property OrderKotStatus[] $orderKotStatuses
 */
class OrderKot extends \yii\db\ActiveRecord
{
    const KOT_RECEIVED = 1;
    const KOT_SERVED = 2;
    const KOT_CANCELLED = 3;

    public static $kot_statuses = [
        self::KOT_RECEIVED => 'Received',
        self::KOT_SERVED => 'Served',
        self::KOT_CANCELLED => 'Cancelled'
    ];

    public static function tableName()
    {
        return 'order_kot';
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
            [['order_id', 'current_status', 'created_at', 'updated_at'], 'integer'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'current_status' => 'Current Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['order_kot_id' => 'id']);
    }

    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    public function getOrderKotStatuses()
    {
        return $this->hasMany(OrderKotStatus::className(), ['order_kot_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if($insert){
            $orderKotStatus = new OrderKotStatus;
            $orderKotStatus->order_kot_id = $this->id;
            $orderKotStatus->order_id = $this->order_id;
            $orderKotStatus->kot_status = $this->current_status;
            $orderKotStatus->save();
        }
        return parent::afterSave($insert, $changedAttributes);
    }
}
