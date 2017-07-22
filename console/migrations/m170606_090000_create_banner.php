<?php

use yii\db\Migration;

class m170606_090000_create_banner extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $table = '{{%banner}}';

        $this->createTable($table, [
            // Primary key
            'id' => $this->primaryKey(),

            // Foreign keys
            'creator_id' => $this->integer(),
            'updater_id' => $this->integer(),
            'image_id' => $this->integer(),

            // Unique

            // Text
            'name' => $this->string()->notNull(),
            'link' => $this->string(),
            'caption' => $this->string(),

            // Flag
            'active' => $this->smallInteger(1),

            // Other
            'type' => $this->smallInteger(),
            'sort_order' => $this->integer(),

            // Time
            'create_time' => $this->integer(),
            'update_time' => $this->integer(),

        ], $tableOptions);

        // Foreign key
        $this->addForeignKey('banner_ibfk_1', $table, 'creator_id', 'user', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('banner_ibfk_2', $table, 'updater_id', 'user', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('banner_ibfk_3', $table, 'image_id', 'image', 'id', 'SET NULL', 'CASCADE');

    }

    public function down()
    {
        $this->dropTable('{{%banner}}');
    }
}
