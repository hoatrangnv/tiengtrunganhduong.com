<?php

use yii\db\Migration;

class m170623_090000_alter_url_redirection extends Migration
{
    public function up()
    {
        $table = '{{%url_redirection}}';
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->addColumn($table, 'response_code', $this->smallInteger());
        }
    }

    public function down()
    {
    }
}
