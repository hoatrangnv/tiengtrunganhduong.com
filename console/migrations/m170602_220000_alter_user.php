<?php

use yii\db\Migration;

class m170602_220000_alter_user extends Migration
{
    public function up()
    {
        $table = '{{%user}}';
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->addColumn($table, 'type', $this->smallInteger());
        }
    }

    public function down()
    {
    }
}
