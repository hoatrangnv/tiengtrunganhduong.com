<?php

use yii\db\Migration;

class m170612_020000_create_seo_info_site_param_redirected_url extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // SEO info
        $table = '{{%seo_info}}';
        $this->createTable($table, [
            // Primary key
            'id' => $this->primaryKey(),

            // Foreign keys
            'creator_id' => $this->integer(),
            'updater_id' => $this->integer(),
            'image_id' => $this->integer(),

            // Text
            'url' => $this->string(511),
            'route' => $this->string(),
            'name' => $this->string()->notNull(),
            'meta_title' => $this->string(),
            'meta_keywords' => $this->string(511),
            'meta_description' => $this->string(511),
            'description' => $this->string(511),
            'long_description' => $this->text(),
            'content' => $this->text(),

            // Flag
            'active' => $this->smallInteger(1),

            // Other
            'type' => $this->smallInteger(),
            'status' => $this->smallInteger(),
            'sort_order' => $this->integer(),

            // Time
            'create_time' => $this->integer(),
            'update_time' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey('seo_info_ibfk_1', $table, 'creator_id', 'user', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('seo_info_ibfk_2', $table, 'updater_id', 'user', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('seo_info_ibfk_3', $table, 'image_id', 'image', 'id', 'SET NULL', 'CASCADE');

        // Site param
        $table = '{{%site_param}}';
        $this->createTable($table, [
            // Primary key
            'id' => $this->primaryKey(),

            // Foreign keys
            'creator_id' => $this->integer(),
            'updater_id' => $this->integer(),

            // Text
            'name' => $this->string()->notNull(),
            'value' => $this->text()->notNull(),

            // Flag
            'active' => $this->smallInteger(1),

            // Other
            'type' => $this->smallInteger(),
            'status' => $this->smallInteger(),
            'sort_order' => $this->integer(),

            // Time
            'create_time' => $this->integer(),
            'update_time' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey('site_param_ibfk_1', $table, 'creator_id', 'user', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('site_param_ibfk_2', $table, 'updater_id', 'user', 'id', 'SET NULL', 'CASCADE');

        // Redirected url
        $table = '{{%redirected_url}}';
        $this->createTable($table, [
            // Primary key
            'id' => $this->primaryKey(),

            // Foreign keys
            'creator_id' => $this->integer(),
            'updater_id' => $this->integer(),

            // Text
            'from_urls' => $this->text()->notNull(),
            'to_url' => $this->string()->notNull(),

            // Flag
            'active' => $this->smallInteger(1),

            // Other
            'type' => $this->smallInteger(),
            'status' => $this->smallInteger(),
            'sort_order' => $this->integer(),

            // Time
            'create_time' => $this->integer(),
            'update_time' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey('redirected_url_ibfk_1', $table, 'creator_id', 'user', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('redirected_url_ibfk_2', $table, 'updater_id', 'user', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%article}}');
    }
}
