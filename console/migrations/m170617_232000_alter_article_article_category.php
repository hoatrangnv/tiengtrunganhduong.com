<?php

use yii\db\Migration;

class m170617_232000_alter_article_article_category extends Migration
{
    public function up()
    {
        $table = '{{%article}}';
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->addColumn($table, 'menu_label', $this->string());
        }

        $table = '{{%article_category}}';
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->addColumn($table, 'menu_label', $this->string());
        }
    }

    public function down()
    {
    }
}
