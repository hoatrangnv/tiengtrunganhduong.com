<?php

use yii\db\Migration;

class m170602_230000_alter_user extends Migration
{
    public function up()
    {
        $table = '{{%user}}';
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->addColumn($table, 'activation_token', $this->string());
            $this->renameColumn($table, 'created_at', 'create_time');
            $this->renameColumn($table, 'updated_at', 'update_time');
        }
    }

    public function down()
    {
    }
}
