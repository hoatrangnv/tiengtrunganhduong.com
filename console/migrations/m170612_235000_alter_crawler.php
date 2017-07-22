<?php

use yii\db\Migration;

class m170612_235000_alter_crawler extends Migration
{
    public function up()
    {
        $table = '{{%crawler}}';
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->addColumn($table, 'error_message', $this->text());
            $this->addColumn($table, 'time', $this->dateTime());
        }
    }

    public function down()
    {
    }
}
