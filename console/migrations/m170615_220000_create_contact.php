<?php

use yii\db\Migration;

class m170615_220000_create_contact extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $table = '{{%contact}}';

        $this->createTable($table, [
            // Primary key
            'id' => $this->primaryKey(),

//            // Foreign keys
            'updater_id' => $this->integer(),
//            'respondent_id' => $this->integer(),

            // Text
            'name' => $this->string(),
            'email' => $this->string(),
            'subject' => $this->string(),
            'body' => $this->text(),

            // Other
            'type' => $this->smallInteger(),
            'status' => $this->smallInteger(),

            // Time
            'create_time' => $this->integer(),
            'update_time' => $this->integer(),

        ], $tableOptions);

        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->addForeignKey('contact_ibfk_1', $table, 'updater_id', 'user', 'id', 'SET NULL', 'CASCADE');
//            $this->addForeignKey('contact_ibfk_2', $table, 'respondent_id', 'user', 'id', 'SET NULL', 'CASCADE');
        }
    }

    public function down()
    {
        $this->dropTable('{{%contact}}');
    }
}
