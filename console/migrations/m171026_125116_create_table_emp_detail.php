<?php

use yii\db\Migration;

class m171026_125116_create_table_emp_detail extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%emp_detail}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'email' => $this->string(),
            'mobile' => $this->string(),
            'emergency_contact' => $this->string(),
            'designation' => $this->string(),
            'date_of_birth' => $this->integer(),
            'date_of_joining' => $this->integer(),
            'salary' => $this->float(),
        ], $tableOptions);

        $this->addForeignkey("fk_emp_detail_user", "emp_detail", "user_id", "user", "id");
    }

    public function safeDown()
    {
        $this->dropForeignkey("fk_emp_detail_user", "emp_detail");
        $this->dropTable("emp_detail");
    }
}
