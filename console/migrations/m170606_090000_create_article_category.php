<?php

use yii\db\Migration;

class m170606_090000_create_article_category extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $table = '{{%article_category}}';

        $this->createTable($table, [
            // Primary key
            'id' => $this->primaryKey(),

            // Foreign keys
            'creator_id' => $this->integer(),
            'updater_id' => $this->integer(),
            'image_id' => $this->integer(),
            'parent_id' => $this->integer(),

            // Unique
            'slug' => $this->string()->notNull()->unique(),

            // Text
            'name' => $this->string()->notNull(),
            'meta_title' => $this->string(),
            'meta_description' => $this->string(511),
            'meta_keywords' => $this->string(511),
            'description' => $this->string(511),
            'long_description' => $this->text(),

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

        ], $tableOptions);

        // Foreign key for article category
        $this->addForeignKey('article_category_ibfk_1', $table, 'creator_id', 'user', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('article_category_ibfk_2', $table, 'updater_id', 'user', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('article_category_ibfk_3', $table, 'image_id', 'image', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('article_category_ibfk_4', $table, 'parent_id', 'article_category', 'id', 'SET NULL', 'CASCADE');

        // Foreign key for article
        $this->addForeignKey('article_ibfk_4', '{{%article}}', 'category_id', 'article_category', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%article}}');
    }
}
