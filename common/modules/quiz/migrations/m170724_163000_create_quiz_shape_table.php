<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_shape`.
 * Has foreign keys to the tables:
 *
 * - `image`
 * - `quiz`
 */
class m170724_163000_create_quiz_shape_table extends Migration
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
        $this->createTable('quiz_shape', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'text' => $this->string(),
            'image_id' => $this->integer(),
            'quiz_id' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `image_id`
        $this->createIndex(
            'idx-quiz_shape-image_id',
            'quiz_shape',
            'image_id'
        );

        // add foreign key for table `image`
        $this->addForeignKey(
            'fk-quiz_shape-image_id',
            'quiz_shape',
            'image_id',
            'image',
            'id',
            'CASCADE'
        );

        // creates index for column `quiz_id`
        $this->createIndex(
            'idx-quiz_shape-quiz_id',
            'quiz_shape',
            'quiz_id'
        );

        // add foreign key for table `quiz`
        $this->addForeignKey(
            'fk-quiz_shape-quiz_id',
            'quiz_shape',
            'quiz_id',
            'quiz',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `image`
        $this->dropForeignKey(
            'fk-quiz_shape-image_id',
            'quiz_shape'
        );

        // drops index for column `image_id`
        $this->dropIndex(
            'idx-quiz_shape-image_id',
            'quiz_shape'
        );

        // drops foreign key for table `quiz`
        $this->dropForeignKey(
            'fk-quiz_shape-quiz_id',
            'quiz_shape'
        );

        // drops index for column `quiz_id`
        $this->dropIndex(
            'idx-quiz_shape-quiz_id',
            'quiz_shape'
        );

        $this->dropTable('quiz_shape');
    }
}
