<?php

use yii\db\Migration;

class m170617_173000_doindex_dofollow extends Migration
{
    public function up()
    {
        $tables = ['{{%article}}', '{{%article_category}}'];
        foreach ($tables as $table) {
            if ($this->db->schema->getTableSchema($table, true) !== null) {
                $this->addColumn($table, 'doindex', $this->smallInteger(1)->defaultValue(1));
                $this->addColumn($table, 'dofollow', $this->smallInteger(1)->defaultValue(1));
            }
        }
    }

    public function down()
    {
    }
}
