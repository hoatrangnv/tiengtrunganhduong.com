<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_input_option_to_result_poll`.
 * Has foreign keys to the tables:
 *
 * - `quiz_result`
 * - `quiz_input_option`
 */
class m170709_182508_create_quiz_input_option_to_result_poll_table extends Migration
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
        $this->createTable('quiz_input_option_to_result_poll', [
            'id' => $this->primaryKey(),
            'votes' => $this->integer()->notNull(),
            'result_id' => $this->integer()->notNull(),
            'input_option_id' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `result_id`
        $this->createIndex(
            'idx-quiz_input_option_to_result_poll-result_id',
            'quiz_input_option_to_result_poll',
            'result_id'
        );

        // add foreign key for table `quiz_result`
        $this->addForeignKey(
            'fk-quiz_input_option_to_result_poll-result_id',
            'quiz_input_option_to_result_poll',
            'result_id',
            'quiz_result',
            'id',
            'CASCADE'
        );

        // creates index for column `input_option_id`
        $this->createIndex(
            'idx-quiz_input_option_to_result_poll-input_option_id',
            'quiz_input_option_to_result_poll',
            'input_option_id'
        );

        // add foreign key for table `quiz_input_option`
        $this->addForeignKey(
            'fk-quiz_input_option_to_result_poll-input_option_id',
            'quiz_input_option_to_result_poll',
            'input_option_id',
            'quiz_input_option',
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
            'fk-quiz_input_option_to_result_poll-result_id',
            'quiz_input_option_to_result_poll'
        );

        // drops index for column `result_id`
        $this->dropIndex(
            'idx-quiz_input_option_to_result_poll-result_id',
            'quiz_input_option_to_result_poll'
        );

        // drops foreign key for table `quiz_input_option`
        $this->dropForeignKey(
            'fk-quiz_input_option_to_result_poll-input_option_id',
            'quiz_input_option_to_result_poll'
        );

        // drops index for column `input_option_id`
        $this->dropIndex(
            'idx-quiz_input_option_to_result_poll-input_option_id',
            'quiz_input_option_to_result_poll'
        );

        $this->dropTable('quiz_input_option_to_result_poll');
    }
}
