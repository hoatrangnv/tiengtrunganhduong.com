<?php

use yii\db\Migration;

class m170625_185500_create_article extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $table = 'article';

        // Check if the table exists
        if ($this->db->schema->getTableSchema($table, true) === null) {
            $this->createTable($table, [
                // Primary key
                'id' => $this->primaryKey(),

                // Foreign keys
                'creator_id' => $this->integer(),
                'updater_id' => $this->integer(),
                'image_id' => $this->integer(),
                'category_id' => $this->integer(),

                // Unique
                'slug' => $this->string()->notNull()->unique(),

                // Text
                'name' => $this->string()->notNull(),
                'title' => $this->string(),
                'meta_title' => $this->string(),
                'meta_description' => $this->string(511),
                'meta_keywords' => $this->string(511),
                'description' => $this->string(511),
                'content' => $this->getDb()->getSchema()->createColumnSchemaBuilder('mediumtext'),
                'sub_content' => $this->text(),
                'related_article_ids' => $this->string(),

                // Flag
                'active' => $this->smallInteger(1),
                'visible' => $this->smallInteger(1),
                'featured' => $this->smallInteger(1),

                // Other
                'type' => $this->smallInteger(),
                'status' => $this->smallInteger(),
                'sort_order' => $this->integer(),

                // Time
                'create_time' => $this->integer(),
                'update_time' => $this->integer(),
                'publish_time' => $this->integer(),

                // Counter
                'view_count' => $this->integer(),
                'like_count' => $this->integer(),
                'comment_count' => $this->integer(),
                'share_count' => $this->integer(),
            ], $tableOptions);

            // Foreign key with `user` table
            $userTable = 'user';
            if ($this->db->schema->getTableSchema($userTable, true) !== null) {
                $this->addForeignKey('article_ibfk_1', $table, 'creator_id', $userTable, 'id', 'SET NULL', 'CASCADE');
                $this->addForeignKey('article_ibfk_2', $table, 'updater_id', $userTable, 'id', 'SET NULL', 'CASCADE');
            }

            // Foreign key with `image` table
            $imageTable = 'image';
            if ($this->db->schema->getTableSchema($imageTable, true) !== null) {
                $this->addForeignKey('article_ibfk_3', $table, 'image_id', $imageTable, 'id', 'SET NULL', 'CASCADE');
            }

            // Foreign key with `article_category` table
            $categoryTable = 'article_category';
            if ($this->db->schema->getTableSchema($categoryTable, true) !== null) {
                $this->addForeignKey('article_ibfk_4', $table, 'category_id', $categoryTable, 'id', 'SET NULL', 'CASCADE');
            }
        }
    }

    public function down()
    {
        $table = 'article';
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->dropTable($table);
        }
    }
}
