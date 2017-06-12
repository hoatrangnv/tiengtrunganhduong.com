<?php

use yii\db\Migration;

class m170612_234000_alter_crawler extends Migration
{
    public function up()
    {
        $table = '{{%crawler}}';
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->alterColumn($table, 'content', $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'));
        }
    }

    public function down()
    {
    }
}
