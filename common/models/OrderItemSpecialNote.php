<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_item_special_note".
 *
 * @property integer $id
 * @property integer $special_note_id
 * @property integer $order_item_id
 *
 * @property OrderItem $orderItem
 * @property SpecialNote $specialNote
 */
class OrderItemSpecialNote extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_item_special_note';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['special_note_id', 'order_item_id'], 'integer'],
            [['order_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrderItem::className(), 'targetAttribute' => ['order_item_id' => 'id']],
            [['special_note_id'], 'exist', 'skipOnError' => true, 'targetClass' => SpecialNote::className(), 'targetAttribute' => ['special_note_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'special_note_id' => 'Special Note ID',
            'order_item_id' => 'Order Item ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItem()
    {
        return $this->hasOne(OrderItem::className(), ['id' => 'order_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecialNote()
    {
        return $this->hasOne(SpecialNote::className(), ['id' => 'special_note_id']);
    }
}
