<?php

use yii\db\Migration;

class m170613_180000_alter_article extends Migration
{
    public function up()
    {
        $table = '{{%article}}';
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->alterColumn($table, 'content', $this->getDb()->getSchema()->createColumnSchemaBuilder('mediumtext'));
        }
    }

    public function down()
    {
    }
}
