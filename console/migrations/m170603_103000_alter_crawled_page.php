<?php

use yii\db\Migration;

class m170603_103000_alter_crawled_page extends Migration
{
    public function up()
    {
        $table = '{{%crawled_page}}';
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->alterColumn($table, 'name', $this->string()->null());
        }
    }

    public function down()
    {
    }
}
