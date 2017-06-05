<?php

use yii\db\Migration;

class m170603_170000_alter_crawled_page extends Migration
{
    public function up()
    {
        $table = '{{%crawled_page}}';
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->alterColumn($table, 'url', $this->string()->unique());
        }
    }

    public function down()
    {
    }
}
