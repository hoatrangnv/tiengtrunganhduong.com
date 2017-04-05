<?php

use yii\db\Migration;

class m170405_100000_alter_image extends Migration
{
    public function up()
    {
        $table = '{{%image}}';
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->addColumn($table, 'sort_order', $this->smallInteger());
        }
    }

    public function down()
    {
    }
}
