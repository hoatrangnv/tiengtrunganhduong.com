<?php

use yii\db\Migration;

class m170615_110000_alter_article extends Migration
{
    public function up()
    {
        $table = '{{%article}}';
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->addColumn($table, 'show_on_menu', $this->smallInteger(1));
        }

        $table = '{{%article_category}}';
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->addColumn($table, 'show_on_menu', $this->smallInteger(1));
        }


    }

    public function down()
    {
    }
}
