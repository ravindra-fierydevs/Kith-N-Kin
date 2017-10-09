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
            'current_status' => $this->smallInteger(),
            'is_discount_applied' => $this->smallInteger(),
            'discount_in'  => $this->smallInteger(),
            'discount_value' => $this->float(),
            'total_price' => $this->float(),
            'total_price_with_discount' => $this->float(),

            'created_at'  => $this->integer(),
            'created_by'  => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),

        ], $tableOptions);

        $this->createTable('{{%order_status}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'order_status' => $this->smallInteger(),

            'created_at'  => $this->integer(),
            'updated_at' => $this->integer(),

        ], $tableOptions);

        $this->createTable('{{%kot}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'food_item_id' => $this->integer(),
            'quantity' => $this->float(),
            'price_each'  => $this->float(),
            'price_total' => $this->float(),

            'created_at'  => $this->integer(),
            'updated_at' => $this->integer(),

        ], $tableOptions);


        $this->addForeignkey("fk_order_created_by", "order", "created_by", "user", "id", 'CASCADE', 'SET NULL');
        $this->addForeignkey("fk_order_updated_by", "order", "updated_at", "user", "id", 'CASCADE', 'SET NULL');

        $this->addForeignkey("fk_order_status_order", "order_status", "order_id", "order", "id", 'CASCADE', 'CASCADE');

        $this->addForeignkey("fk_kot_order", "kot", "order_id", "order", "id", 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_order_created_by', 'order');
        $this->dropForeignKey('fk_order_updated_by', 'order');
        $this->dropForeignKey('fk_order_status_order', 'order_status');
        $this->dropForeignKey('fk_kot_order', 'kot');

        $this->dropTable('order');
        $this->dropTable('order_status');
        $this->dropTable('kot');
    }
}
