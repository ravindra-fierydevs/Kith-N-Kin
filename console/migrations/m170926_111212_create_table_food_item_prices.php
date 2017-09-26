<?php

use yii\db\Migration;

class m170926_111212_create_table_food_item_prices extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%food_item_price}}', [
            'id' => $this->primaryKey(),
            'food_item_id' => $this->integer(),
            'half_price' => $this->float(),
            'full_price' => $this->float(),
        ], $tableOptions);

        $this->addForeignkey("fk_food_item_price_food_item", "food_item_price", "food_item_id", "food_item", "id", 'RESTRICT', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_food_item_price_food_item', 'food_item_price');
        $this->dropTable('food_item_price');
    }
}
