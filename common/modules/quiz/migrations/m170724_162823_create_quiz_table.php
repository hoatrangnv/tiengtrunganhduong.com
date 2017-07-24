<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz`.
 * Has foreign keys to the tables:
 *
 * - `user`
 * - `user`
 * - `image`
 * - `quiz_category`
 */
class m170724_162823_create_quiz_table extends Migration
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
        $this->createTable('quiz', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'slug' => $this->string()->notNull()->unique(),
            'introduction' => $this->text(),
            'duration' => $this->integer(),
            'description' => $this->string(511),
            'meta_title' => $this->string(),
            'meta_description' => $this->string(511),
            'meta_keywords' => $this->string(511),
            'sort_order' => $this->integer(),
            'active' => $this->integer(),
            'visible' => $this->integer(),
            'doindex' => $this->integer(),
            'dofollow' => $this->integer(),
            'featured' => $this->integer(),
            'create_time' => $this->integer()->notNull(),
            'update_time' => $this->integer()->notNull(),
            'publish_time' => $this->integer()->notNull(),
            'creator_id' => $this->integer()->notNull(),
            'updater_id' => $this->integer()->notNull(),
            'image_id' => $this->integer(),
            'quiz_category_id' => $this->integer(),
        ], $tableOptions);

        // creates index for column `creator_id`
        $this->createIndex(
            'idx-quiz-creator_id',
            'quiz',
            'creator_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-quiz-creator_id',
            'quiz',
            'creator_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `updater_id`
        $this->createIndex(
            'idx-quiz-updater_id',
            'quiz',
            'updater_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-quiz-updater_id',
            'quiz',
            'updater_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `image_id`
        $this->createIndex(
            'idx-quiz-image_id',
            'quiz',
            'image_id'
        );

        // add foreign key for table `image`
        $this->addForeignKey(
            'fk-quiz-image_id',
            'quiz',
            'image_id',
            'image',
            'id',
            'CASCADE'
        );

        // creates index for column `quiz_category_id`
        $this->createIndex(
            'idx-quiz-quiz_category_id',
            'quiz',
            'quiz_category_id'
        );

        // add foreign key for table `quiz_category`
        $this->addForeignKey(
            'fk-quiz-quiz_category_id',
            'quiz',
            'quiz_category_id',
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
            'fk-quiz-creator_id',
            'quiz'
        );

        // drops index for column `creator_id`
        $this->dropIndex(
            'idx-quiz-creator_id',
            'quiz'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-quiz-updater_id',
            'quiz'
        );

        // drops index for column `updater_id`
        $this->dropIndex(
            'idx-quiz-updater_id',
            'quiz'
        );

        // drops foreign key for table `image`
        $this->dropForeignKey(
            'fk-quiz-image_id',
            'quiz'
        );

        // drops index for column `image_id`
        $this->dropIndex(
            'idx-quiz-image_id',
            'quiz'
        );

        // drops foreign key for table `quiz_category`
        $this->dropForeignKey(
            'fk-quiz-quiz_category_id',
            'quiz'
        );

        // drops index for column `quiz_category_id`
        $this->dropIndex(
            'idx-quiz-quiz_category_id',
            'quiz'
        );

        $this->dropTable('quiz');
    }
}
