<?php

use yii\db\Migration;

class m171026_114617_create_table_special_note_and_order_item_special_note extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%special_note}}', [
            'id' => $this->primaryKey(),
            'note' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),

        ], $tableOptions);

        $this->createTable('{{%order_item_special_note}}', [
            'id' => $this->primaryKey(),
            'special_note_id' => $this->integer(),
            'order_item_id' => $this->integer(),

        ], $tableOptions);

        $this->addForeignKey("fk_order_item_special_note_special_note", "order_item_special_note", "special_note_id", "special_note", "id", "CASCADE", "SET NULL");
        $this->addForeignKey("fk_order_item_special_note_order_item", "order_item_special_note", "order_item_id", "order_item", "id", "CASCADE", "CASCADE");
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_order_item_special_note_special_note', 'order_item_special_note');
        $this->dropForeignKey('fk_order_item_special_note_order_item', 'order_item_special_note');
        $this->dropTable("order_item_special_note");
        $this->dropTable("special_note");
    }
}
