<?php

use yii\db\Migration;

class m171009_181528_create_table_KOT_and_ORDER extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'unique_id' => $this->string(),
            'order_number' => $this->integer(),
            'table_id' => $this->integer(), // fk_order_table
            'current_status' => $this->smallInteger(),
            'type' => $this->smallInteger(),
            'is_discount_applied' => $this->smallInteger(),
            'discount_in'  => $this->smallInteger(),
            'discount_value' => $this->float(),
            'total_price' => $this->float(),
            'total_price_with_discount' => $this->float(),

            'created_at'  => $this->integer(),
            'created_by'  => $this->integer(), // fk_order_created_by
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(), // fk_order_updated_by

        ], $tableOptions);

        $this->createTable('{{%order_kot}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(), // fk_order_kot_order
            'current_status' => $this->smallInteger(),

            'created_at'  => $this->integer(),
            'updated_at' => $this->integer(),

        ], $tableOptions);

        $this->createTable('{{%order_status}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(), // fk_order_status_order
            'order_status' => $this->smallInteger(),

            'created_at'  => $this->integer(),
            'updated_at' => $this->integer(),

        ], $tableOptions);

        $this->createTable('{{%order_kot_status}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(), // fk_order_kot_status_order
            'order_kot_id' => $this->integer(), // fk_order_kot_status_order_kot
            'kot_status' => $this->smallInteger(),

            'created_at'  => $this->integer(),
            'updated_at' => $this->integer(),

        ], $tableOptions);


        $this->createTable('{{%order_item}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(), // fk_order_item_order
            'order_kot_id' => $this->integer(), // fk_order_item_order_kot
            'food_item_id' => $this->integer(), // fk_order_item_food_item
            'quantity' => $this->float(),
            'price_each'  => $this->float(),
            'price_total' => $this->float(),

            'created_at'  => $this->integer(),
            'updated_at' => $this->integer(),

        ], $tableOptions);


        $this->addForeignkey("fk_order_created_by", "order", "created_by", "user", "id", 'CASCADE', 'SET NULL');
        $this->addForeignkey("fk_order_updated_by", "order", "updated_at", "user", "id", 'CASCADE', 'SET NULL');

        $this->addForeignkey("fk_order_status_order", "order_status", "order_id", "order", "id", 'CASCADE', 'CASCADE');

        $this->addForeignkey("fk_order_table", "order", "table_id", "table", "id", 'RESTRICT', 'RESTRICT');

        $this->addForeignkey("fk_order_kot_order", "order_kot", "order_id", "order", "id", 'CASCADE', 'CASCADE');

        $this->addForeignkey("fk_order_kot_status_order", "order_kot_status", "order_id", "order", "id", 'CASCADE', 'CASCADE');
        $this->addForeignkey("fk_order_kot_status_order_kot", "order_kot_status", "order_kot_id", "order_kot", "id", 'CASCADE', 'CASCADE');

        $this->addForeignkey("fk_order_item_order", "order_item", "order_id", "order", "id", 'CASCADE', 'CASCADE');
        $this->addForeignkey("fk_order_item_order_kot", "order_item", "order_kot_id", "order_kot", "id", 'CASCADE', 'CASCADE');
        $this->addForeignkey("fk_order_item_food_item", "order_item", "food_item_id", "food_item", "id", 'RESTRICT', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_order_created_by', 'order');
        $this->dropForeignKey('fk_order_updated_by', 'order');
        $this->dropForeignKey('fk_order_status_order', 'order_status');
        $this->dropForeignKey('fk_order_table', 'order');
        $this->dropForeignKey('fk_order_kot_order', 'order_kot');
        $this->dropForeignKey('fk_order_kot_status_order', 'order_kot_status');
        $this->dropForeignKey('fk_order_kot_status_order_kot', 'order_kot_status');
        $this->dropForeignKey('fk_order_item_order', 'order_item');
        $this->dropForeignKey('fk_order_item_order_kot', 'order_item');
        $this->dropForeignKey('fk_order_item_food_item', 'order_item');

        $this->dropTable('order');
        $this->dropTable('order_kot');
        $this->dropTable('order_status');
        $this->dropTable('order_kot_status');
        $this->dropTable('order_item');
    }
}
