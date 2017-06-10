<?php

use yii\db\Migration;

class m170610_143000_alter_image extends Migration
{
    public function up()
    {
        $table = '{{%image}}';
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->dropColumn($table, 'quantity');
            $this->addColumn($table, 'quality', $this->smallInteger(3)->notNull());
        }
    }

    public function down()
    {
    }
}
