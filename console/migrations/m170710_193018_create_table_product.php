<?php

use yii\db\Migration;

class m170710_193018_create_table_product extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(),
            'name' => $this->string(),
            'type' => $this->smallInteger(),
            'quantity_type' => $this->string,
            'price' => $this->float(),
            'is_veg' => $this->smallInteger(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),

        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('product');
    }
}
