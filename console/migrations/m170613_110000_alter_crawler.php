<?php

use yii\db\Migration;

class m170613_110000_alter_crawler extends Migration
{
    public function up()
    {
        $table = '{{%crawler}}';
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->alterColumn($table, 'url', $this->string(1023)->notNull());
        }
    }

    public function down()
    {
    }
}
