<?php

use yii\db\Migration;

class m170610_140000_alter_image extends Migration
{
    public function up()
    {
        $table = '{{%image}}';
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->addColumn($table, 'quantity', $this->smallInteger(2)->notNull());
            $this->addColumn($table, 'aspect_ratio', $this->string(32)->notNull());
        }
    }

    public function down()
    {
    }
}
