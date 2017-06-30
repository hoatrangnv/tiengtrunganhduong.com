<?php

use yii\db\Migration;

class m170624_144000_create_image extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $table = 'image';

        // Check if the table exists
        if ($this->db->schema->getTableSchema($table, true) === null) {
            $this->createTable($table, [
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
                'quality' => $this->smallInteger(3)->notNull(),
                'aspect_ratio' => $this->string(32)->notNull(),
                'width' => $this->integer()->notNull(),
                'height' => $this->integer()->notNull(),

                //
                'description' => $this->string(511),
                'resize_labels' => $this->string(2047),
                'encode_data' => $this->string(2047),

                // Flag
                'active' => $this->smallInteger(1),

                // Status
                'status' => $this->smallInteger(),

                // Other
                'sort_order' => $this->smallInteger(),

                // Time
                'create_time' => $this->integer(),
                'update_time' => $this->integer(),
            ], $tableOptions);

            // Foreign key with `user` table
            $userTable = 'user';
            if ($this->db->schema->getTableSchema($userTable, true) !== null) {
                $this->addForeignKey('image_ibfk_1', $table, 'creator_id', $userTable, 'id', 'SET NULL', 'CASCADE');
                $this->addForeignKey('image_ibfk_2', $table, 'updater_id', $userTable, 'id', 'SET NULL', 'CASCADE');
            }
        }
    }

    public function down()
    {
        $table = 'image';
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->dropTable($table);
        }
    }
}
