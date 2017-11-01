<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property string $unique_id
 * @property integer $order_number
 * @property integer $table_id
 * @property integer $current_status
 * @property integer $type
 * @property integer $is_discount_applied
 * @property integer $discount_in
 * @property double $discount_value
 * @property double $total_price
 * @property double $total_price_with_discount
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property User $createdBy
 * @property Table $table
 * @property User $updatedAt
 * @property OrderItem[] $orderItems
 * @property OrderKot[] $orderKots
 * @property OrderKotStatus[] $orderKotStatuses
 * @property OrderStatus[] $orderStatuses
 */
class Order extends \yii\db\ActiveRecord
{
    const STATUS_IN_PROGRESS = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_CANCELLED = 3;

    public static $statuses = [
        self::STATUS_IN_PROGRESS => 'In Progress',
        self::STATUS_COMPLETED => 'Completed',
        self::STATUS_CANCELLED => 'Cancelled'
    ];

    const TYPE_TABLE_ORDER = 1;
    const TYPE_PARCEL_ORDER = 2;
    const TYPE_DELIVERY_ORDER = 3;

    public static $types = [
        self::TYPE_TABLE_ORDER => 'Table',
        self::TYPE_PARCEL_ORDER => 'Parcel',
        self::TYPE_DELIVERY_ORDER => 'Delivery'
    ];

    public static function tableName()
    {
        return 'order';
    }

    public function rules()
    {
        return [
            [['order_number', 'table_id', 'current_status', 'type', 'is_discount_applied', 'discount_in', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['discount_value', 'total_price', 'total_price_with_discount'], 'number'],
            [['unique_id'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['table_id'], 'exist', 'skipOnError' => true, 'targetClass' => Table::className(), 'targetAttribute' => ['table_id' => 'id']],
            [['updated_at'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_at' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unique_id' => 'Unique ID',
            'order_number' => 'Order Number',
            'table_id' => 'Table ID',
            'current_status' => 'Current Status',
            'type' => 'Type',
            'is_discount_applied' => 'Is Discount Applied',
            'discount_in' => 'Discount In',
            'discount_value' => 'Discount Value',
            'total_price' => 'Total Price',
            'total_price_with_discount' => 'Total Price With Discount',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getTable()
    {
        return $this->hasOne(Table::className(), ['id' => 'table_id']);
    }

    public function getUpdatedAt()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_at']);
    }

    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['order_id' => 'id']);
    }

    public function getOrderKots()
    {
        return $this->hasMany(OrderKot::className(), ['order_id' => 'id']);
    }

    public function getOrderKotStatuses()
    {
        return $this->hasMany(OrderKotStatus::className(), ['order_id' => 'id']);
    }

    public function getOrderStatuses()
    {
        return $this->hasMany(OrderStatus::className(), ['order_id' => 'id']);
    }
}
