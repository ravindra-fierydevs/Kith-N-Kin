<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "table".
 *
 * @property integer $id
 * @property string $name_prefix
 * @property integer $number
 * @property integer $capacity
 * @property integer $created_at
 * @property integer $updated_at
 */
class Table extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'table';
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
            [['number', 'capacity', 'created_at', 'updated_at'], 'integer'],
            [['name_prefix'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_prefix' => 'Name Prefix',
            'number' => 'Number',

            'capacity' => 'Capacity',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getName()
    {
        return $this->name_prefix." ".$this->number;
    }
}
