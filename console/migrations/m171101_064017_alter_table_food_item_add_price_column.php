<?php

use yii\db\Migration;

class m171101_064017_alter_table_food_item_add_price_column extends Migration
{
    public function safeUp()
    {
        $this->addColumn('food_item', 'price', 'float after name');
    }

    public function safeDown()
    {
        
    }
}
