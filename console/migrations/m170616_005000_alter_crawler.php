<?php

use yii\db\Migration;

class m170616_005000_alter_crawler extends Migration
{
    public function up()
    {
        $table = '{{%crawler}}';
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->addColumn($table, 'target_model_type', $this->smallInteger());
            $this->addColumn($table, 'target_model_slug', $this->string());
        }
    }

    public function down()
    {
    }
}
