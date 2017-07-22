<?php

use yii\db\Migration;

class m170615_120000_alter_article extends Migration
{
    public function up()
    {
        $table = '{{%article}}';
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->renameColumn($table, 'show_on_menu', 'shown_on_menu');
        }

        $table = '{{%article_category}}';
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->renameColumn($table, 'show_on_menu', 'shown_on_menu');
        }


    }

    public function down()
    {
    }
}
