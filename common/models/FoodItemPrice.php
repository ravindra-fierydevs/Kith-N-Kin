<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "food_item_price".
 *
 * @property integer $id
 * @property integer $food_item_id
 * @property double $half_price
 * @property double $full_price
 *
 * @property FoodItem $foodItem
 */
class FoodItemPrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'food_item_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['food_item_id'], 'integer'],
            [['half_price', 'full_price'], 'number'],
            [['food_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => FoodItem::className(), 'targetAttribute' => ['food_item_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'food_item_id' => 'Food Item ID',
            'half_price' => 'Half Price',
            'full_price' => 'Full Price',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFoodItem()
    {
        return $this->hasOne(FoodItem::className(), ['id' => 'food_item_id']);
    }
}
