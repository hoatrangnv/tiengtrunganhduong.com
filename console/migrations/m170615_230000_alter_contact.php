<?php

use yii\db\Migration;

class m170615_230000_alter_contact extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $table = '{{%contact}}';

        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->addColumn($table, 'phone_number', $this->string(32));
        }
    }

    public function down()
    {
        $this->dropTable('{{%contact}}');
    }
}
