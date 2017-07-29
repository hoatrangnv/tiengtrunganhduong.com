<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_category`.
 * Has foreign keys to the tables:
 *
 * - `user`
 * - `user`
 * - `image`
 * - `quiz_category`
 */
class m170724_162047_create_quiz_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('quiz_category', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'slug' => $this->string()->notNull()->unique(),
            'description' => $this->string(511),
            'meta_title' => $this->string(),
            'meta_description' => $this->string(511),
            'meta_keywords' => $this->string(511),
            'sort_order' => $this->integer(),
            'active' => $this->smallInteger(1),
            'visible' => $this->smallInteger(1),
            'doindex' => $this->smallInteger(1),
            'dofollow' => $this->smallInteger(1),
            'featured' => $this->smallInteger(1),
            'create_time' => $this->integer()->notNull(),
            'update_time' => $this->integer()->notNull(),
            'creator_id' => $this->integer()->notNull(),
            'updater_id' => $this->integer()->notNull(),
            'image_id' => $this->integer(),
            'parent_id' => $this->integer(),
        ], $tableOptions);

        // creates index for column `creator_id`
        $this->createIndex(
            'idx-quiz_category-creator_id',
            'quiz_category',
            'creator_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-quiz_category-creator_id',
            'quiz_category',
            'creator_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `updater_id`
        $this->createIndex(
            'idx-quiz_category-updater_id',
            'quiz_category',
            'updater_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-quiz_category-updater_id',
            'quiz_category',
            'updater_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `image_id`
        $this->createIndex(
            'idx-quiz_category-image_id',
            'quiz_category',
            'image_id'
        );

        // add foreign key for table `image`
        $this->addForeignKey(
            'fk-quiz_category-image_id',
            'quiz_category',
            'image_id',
            'image',
            'id',
            'CASCADE'
        );

        // creates index for column `parent_id`
        $this->createIndex(
            'idx-quiz_category-parent_id',
            'quiz_category',
            'parent_id'
        );

        // add foreign key for table `quiz_category`
        $this->addForeignKey(
            'fk-quiz_category-parent_id',
            'quiz_category',
            'parent_id',
            'quiz_category',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-quiz_category-creator_id',
            'quiz_category'
        );

        // drops index for column `creator_id`
        $this->dropIndex(
            'idx-quiz_category-creator_id',
            'quiz_category'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-quiz_category-updater_id',
            'quiz_category'
        );

        // drops index for column `updater_id`
        $this->dropIndex(
            'idx-quiz_category-updater_id',
            'quiz_category'
        );

        // drops foreign key for table `image`
        $this->dropForeignKey(
            'fk-quiz_category-image_id',
            'quiz_category'
        );

        // drops index for column `image_id`
        $this->dropIndex(
            'idx-quiz_category-image_id',
            'quiz_category'
        );

        // drops foreign key for table `quiz_category`
        $this->dropForeignKey(
            'fk-quiz_category-parent_id',
            'quiz_category'
        );

        // drops index for column `parent_id`
        $this->dropIndex(
            'idx-quiz_category-parent_id',
            'quiz_category'
        );

        $this->dropTable('quiz_category');
    }
}
