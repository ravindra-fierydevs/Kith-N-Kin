<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "special_note".
 *
 * @property integer $id
 * @property string $note
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property OrderItemSpecialNote[] $orderItemSpecialNotes
 */
class SpecialNote extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'special_note';
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
            [['created_at', 'updated_at'], 'integer'],
            [['note'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'note' => 'Note',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getOrderItemSpecialNotes()
    {
        return $this->hasMany(OrderItemSpecialNote::className(), ['special_note_id' => 'id']);
    }
}
