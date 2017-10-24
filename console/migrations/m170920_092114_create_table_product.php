<?php

use yii\db\Migration;

class m170920_092114_create_table_product extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%food_item}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(),
            'menu_category_id' => $this->integer(),
            'name' => $this->string(),
            'short_name' => $this->string(),
            'item_code' => $this->string(),

            'status' => $this->smallInteger(4),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->addForeignkey("fk_food_item_category", "food_item", "category_id", "category", "id", 'RESTRICT', 'SET NULL');
        $this->addForeignkey("fk_food_item_menu_category", "food_item", "menu_category_id", "menu_category", "id", 'RESTRICT', 'SET NULL');

        $this->addForeignkey("fk_food_item_user_created", "food_item", "created_by", "user", "id", 'RESTRICT', 'RESTRICT');
        $this->addForeignkey("fk_food_item_user_updated", "food_item", "updated_by", 'user', 'id', 'RESTRICT', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_food_item_category', 'food_item');
        $this->dropForeignKey('fk_food_item_menu_category', 'food_item');
        $this->dropForeignKey('fk_food_item_user_created', 'food_item');
        $this->dropForeignKey('fk_food_item_user_updated', 'food_item');
        $this->dropTable('food_item');
    }
}
