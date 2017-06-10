<?php

use yii\db\Migration;

class m170610_173000_alter_image extends Migration
{
    public function up()
    {
        $table = '{{%image}}';
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->addColumn($table, 'size', $this->string(32));
        }
    }

    public function down()
    {
    }
}
