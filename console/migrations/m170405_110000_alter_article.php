<?php

use yii\db\Migration;

class m170405_110000_alter_article extends Migration
{
    public function up()
    {
        $table = '{{%image}}';
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->addForeignKey('image_ibfk_1', $table, 'creator_id', 'user', 'id', 'SET NULL', 'CASCADE');
            $this->addForeignKey('image_ibfk_2', $table, 'updater_id', 'user', 'id', 'SET NULL', 'CASCADE');
        }

        $table = '{{%article}}';
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->addForeignKey('article_ibfk_1', $table, 'creator_id', 'user', 'id', 'SET NULL', 'CASCADE');
            $this->addForeignKey('article_ibfk_2', $table, 'updater_id', 'user', 'id', 'SET NULL', 'CASCADE');
            $this->addForeignKey('article_ibfk_3', $table, 'image_id', 'image', 'id', 'SET NULL', 'CASCADE');
        }
    }

    public function down()
    {
    }
}
