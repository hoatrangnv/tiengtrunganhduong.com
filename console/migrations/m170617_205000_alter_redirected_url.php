<?php

use yii\db\Migration;

class m170617_205000_alter_redirected_url extends Migration
{
    public function up()
    {
        $table = '{{%redirected_url}}';
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->alterColumn($table, 'from_urls', $this->string());
            $this->renameColumn($table, 'from_urls', 'from_url');
        }
    }

    public function down()
    {
    }
}
