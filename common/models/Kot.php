<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "kot".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $food_item_id
 * @property double $quantity
 * @property double $price_each
 * @property double $price_total
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Order $order
 */
class Kot extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kot';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'food_item_id', 'created_at', 'updated_at'], 'integer'],
            [['quantity', 'price_each', 'price_total'], 'number'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
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
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
}
