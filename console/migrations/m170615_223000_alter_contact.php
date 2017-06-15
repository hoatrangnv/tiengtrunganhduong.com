<?php

use yii\db\Migration;

class m170615_223000_alter_contact extends Migration
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
            try {
                $this->addColumn($table, 'creator_id', $this->integer());
                $this->addForeignKey('contact_ibfk_2', $table, 'creator_id', 'user', 'id', 'SET NULL', 'CASCADE');
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        }
    }

    public function down()
    {
        $this->dropTable('{{%contact}}');
    }
}
