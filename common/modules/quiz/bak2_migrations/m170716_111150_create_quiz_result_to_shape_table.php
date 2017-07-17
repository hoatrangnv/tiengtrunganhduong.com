<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_result_to_shape`.
 * Has foreign keys to the tables:
 *
 * - `quiz_result`
 * - `quiz_shape`
 */
class m170716_111150_create_quiz_result_to_shape_table extends Migration
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
        $this->createTable('quiz_result_to_shape', [
            'id' => $this->primaryKey(),
            'quiz_result_id' => $this->integer()->notNull(),
            'quiz_shape_id' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `quiz_result_id`
        $this->createIndex(
            'idx-quiz_result_to_shape-quiz_result_id',
            'quiz_result_to_shape',
            'quiz_result_id'
        );

        // add foreign key for table `quiz_result`
        $this->addForeignKey(
            'fk-quiz_result_to_shape-quiz_result_id',
            'quiz_result_to_shape',
            'quiz_result_id',
            'quiz_result',
            'id',
            'CASCADE'
        );

        // creates index for column `quiz_shape_id`
        $this->createIndex(
            'idx-quiz_result_to_shape-quiz_shape_id',
            'quiz_result_to_shape',
            'quiz_shape_id'
        );

        // add foreign key for table `quiz_shape`
        $this->addForeignKey(
            'fk-quiz_result_to_shape-quiz_shape_id',
            'quiz_result_to_shape',
            'quiz_shape_id',
            'quiz_shape',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `quiz_result`
        $this->dropForeignKey(
            'fk-quiz_result_to_shape-quiz_result_id',
            'quiz_result_to_shape'
        );

        // drops index for column `quiz_result_id`
        $this->dropIndex(
            'idx-quiz_result_to_shape-quiz_result_id',
            'quiz_result_to_shape'
        );

        // drops foreign key for table `quiz_shape`
        $this->dropForeignKey(
            'fk-quiz_result_to_shape-quiz_shape_id',
            'quiz_result_to_shape'
        );

        // drops index for column `quiz_shape_id`
        $this->dropIndex(
            'idx-quiz_result_to_shape-quiz_shape_id',
            'quiz_result_to_shape'
        );

        $this->dropTable('quiz_result_to_shape');
    }
}
