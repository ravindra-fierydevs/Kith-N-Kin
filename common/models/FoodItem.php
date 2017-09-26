<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "food_item".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $menu_category_id
 * @property string $name
 * @property string $short_name
 * @property string $item_code
 * @property integer $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Category $category
 * @property MenuCategory $menuCategory
 * @property User $createdBy
 * @property User $updatedBy
 * @property FoodItemPrice[] $foodItemPrices
 */
class FoodItem extends \yii\db\ActiveRecord
{
	public $half_price, $full_price;

	const STATUS_ACTIVE = 0;
    const STATUS_INACTIVE = 1;
    const STATUS_DELETED = 2;

    public static $statuses = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_DELETED => 'Deleted',
    ];

    public static function tableName()
    {
        return 'food_item';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            [['category_id', 'menu_category_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['name', 'short_name', 'item_code'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['menu_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => MenuCategory::className(), 'targetAttribute' => ['menu_category_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['half_price', 'full_price'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category',
            'menu_category_id' => 'Menu Category',
            'name' => 'Name',
            'short_name' => 'Short Name',
            'item_code' => 'Item Code',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
  
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getMenuCategory()
    {
        return $this->hasOne(MenuCategory::className(), ['id' => 'menu_category_id']);
    }

    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    public function getFoodItemPrices()
    {
        return $this->hasMany(FoodItemPrice::className(), ['food_item_id' => 'id']);
    }

    public function getFoodPrice()
    {
    	return $this->hasOne(FoodItemPrice::className(), ['food_item_id' => 'id']);
    }

    public function loadPrices()
    {
    	$this->half_price = $this->foodPrice->half_price;
    	$this->full_price = $this->foodPrice->full_price;
    }
}
