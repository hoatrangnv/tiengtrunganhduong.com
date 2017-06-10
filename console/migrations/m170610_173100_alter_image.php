<?php

use yii\db\Migration;

class m170610_173100_alter_image extends Migration
{
    public function up()
    {
        $table = '{{%image}}';
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->dropColumn($table, 'size');
            $this->addColumn($table, 'width', $this->integer());
            $this->addColumn($table, 'height', $this->integer());
        }
    }

    public function down()
    {
    }
}
