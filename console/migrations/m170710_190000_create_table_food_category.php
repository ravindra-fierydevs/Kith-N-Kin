<?php

use yii\db\Migration;

class m170710_190000_create_table_food_category extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),

        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('category');
    }
}
