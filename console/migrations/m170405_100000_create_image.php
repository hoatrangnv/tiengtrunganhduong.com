<?php

use yii\db\Migration;

class m170405_100000_create_image extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%image}}', [
            // Primary key
            'id' => $this->primaryKey(),

            // Foreign keys
            'creator_id' => $this->integer(),
            'updater_id' => $this->integer(),

            // Unique
            'file_basename' => $this->string()->notNull()->unique(),

            // Not null
            'path' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'file_extension' => $this->string()->notNull(),
            'mime_type' => $this->string()->notNull(),

            //
            'description' => $this->string(511),
            'resize_labels' => $this->string(2047),
            'encode_data' => $this->string(2047),

            // Flag
            'active' => $this->smallInteger(1),

            // Status
            'status' => $this->smallInteger(),

            // Time
            'create_time' => $this->integer(),
            'update_time' => $this->integer(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%image}}');
    }
}
