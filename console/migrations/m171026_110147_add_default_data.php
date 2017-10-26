<?php

use yii\db\Migration;

class m171026_110147_add_default_data extends Migration
{
    public function safeUp()
    {
        $this->insert('category', [
            'name' => 'Starter',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('category', [
            'name' => 'Main Course',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('category', [
            'name' => 'Dessert',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('menu_category', [
            'name' => 'Chinese',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('menu_category', [
            'name' => 'Punjabi',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    public function safeDown()
    {
        
    }
}
