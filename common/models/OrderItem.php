<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_item".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $order_kot_id
 * @property integer $food_item_id
 * @property double $quantity
 * @property double $price_each
 * @property double $price_total
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property FoodItem $foodItem
 * @property Order $order
 * @property OrderKot $orderKot
 */
class OrderItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'order_kot_id', 'food_item_id', 'created_at', 'updated_at'], 'integer'],
            [['quantity', 'price_each', 'price_total'], 'number'],
            [['food_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => FoodItem::className(), 'targetAttribute' => ['food_item_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['order_kot_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrderKot::className(), 'targetAttribute' => ['order_kot_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'order_kot_id' => 'Order Kot ID',
            'food_item_id' => 'Food Item ID',
            'quantity' => 'Quantity',
            'price_each' => 'Price Each',
            'price_total' => 'Price Total',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFoodItem()
    {
        return $this->hasOne(FoodItem::className(), ['id' => 'food_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderKot()
    {
        return $this->hasOne(OrderKot::className(), ['id' => 'order_kot_id']);
    }
}
