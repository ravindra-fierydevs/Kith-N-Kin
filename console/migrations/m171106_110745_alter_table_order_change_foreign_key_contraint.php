<?php

use yii\db\Migration;

class m171106_110745_alter_table_order_change_foreign_key_contraint extends Migration
{
    public function safeUp()
    {

        $this->dropForeignKey('fk_order_created_by', 'order');
        $this->dropForeignKey('fk_order_updated_by', 'order');
        $this->addForeignkey("fk_order_created_by", "order", "created_by", "user", "id", 'SET NULL', 'SET NULL');
        $this->addForeignkey("fk_order_updated_by", "order", "updated_by", "user", "id", 'SET NULL', 'SET NULL');

    }

    public function safeDown()
    {
        
    }
}
