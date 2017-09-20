<?php

use yii\db\Migration;

/**
 * Handles the creation of table `table`.
 */
class m170920_111641_create_table_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%table}}', [
            'id' => $this->primaryKey(),
            'name_prefix' => $this->string(),
            'number' => $this->integer(),
            'capacity' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),

        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('table');
    }
}
