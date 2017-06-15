<?php

use yii\db\Migration;

class m170615_100000_create_nav_item extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $table = '{{%nav_item}}';

        $this->createTable($table, [
            // Primary key
            'id' => $this->primaryKey(),

            // Foreign keys
            'creator_id' => $this->integer(),
            'updater_id' => $this->integer(),
            'parent_id' => $this->integer(),

            // Text
            'name' => $this->string()->notNull(),
            'target_model_id' => $this->integer(),
            'target_model_type' => $this->smallInteger(),

            // Flag
            'active' => $this->smallInteger(1),

            // Other
            'type' => $this->smallInteger(),
            'sort_order' => $this->integer(),

            // Time
            'create_time' => $this->integer(),
            'update_time' => $this->integer(),
        ], $tableOptions);

        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->addForeignKey('nav_item_ibfk_1', $table, 'creator_id', 'user', 'id', 'SET NULL', 'CASCADE');
            $this->addForeignKey('nav_item_ibfk_2', $table, 'updater_id', 'user', 'id', 'SET NULL', 'CASCADE');
            $this->addForeignKey('nav_item_ibfk_3', $table, 'parent_id', 'nav_item', 'id', 'SET NULL', 'CASCADE');
        }
    }

    public function down()
    {
        $this->dropTable('{{%article}}');
    }
}
