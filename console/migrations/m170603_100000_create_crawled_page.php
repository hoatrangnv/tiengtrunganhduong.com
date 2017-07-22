<?php

use yii\db\Migration;

class m170603_100000_create_crawled_page extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%crawled_page}}', [
            // Primary key
            'id' => $this->primaryKey(),

            //
            'url' => $this->string()->notNull(),
            'type' => $this->string(32),
//            'content' => $this->text(),


//            // Foreign keys
//            'creator_id' => $this->integer(),
//            'updater_id' => $this->integer(),
//            'image_id' => $this->integer(),
//            'category_id' => $this->integer(),
//
//            // Unique
//            'slug' => $this->string()->notNull()->unique(),
//
//            // Text
            'name' => $this->string()->notNull(),
            'meta_title' => $this->string(),
            'meta_description' => $this->string(511),
            'meta_keywords' => $this->string(511),
            'description' => $this->string(511),
            'content' => $this->text(),
//            'sub_content' => $this->text(),
//
//            // Flag
//            'active' => $this->smallInteger(1),
//            'visible' => $this->smallInteger(1),
//            'featured' => $this->smallInteger(1),
//
//            // Other
//            'type' => $this->smallInteger(),
//            'status' => $this->smallInteger(),
//            'sort_order' => $this->integer(),
//
//            // Time
//            'create_time' => $this->integer(),
//            'update_time' => $this->integer(),
//            'publish_time' => $this->integer(),
//
//            // Counter
//            'view_count' => $this->integer(),
//            'like_count' => $this->integer(),
//            'comment_count' => $this->integer(),
//            'share_count' => $this->integer(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%crawled_page}}');
    }
}
