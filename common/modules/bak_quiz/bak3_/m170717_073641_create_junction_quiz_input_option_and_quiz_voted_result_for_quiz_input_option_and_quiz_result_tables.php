<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_input_option_to_voted_result`.
 * Has foreign keys to the tables:
 *
 * - `quiz_input_option`
 * - `quiz_result`
 */
class m170717_073641_create_junction_quiz_input_option_and_quiz_voted_result_for_quiz_input_option_and_quiz_result_tables extends Migration
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
        $this->createTable('quiz_input_option_to_voted_result', [
            'quiz_input_option_id' => $this->integer(),
            'quiz_voted_result_id' => $this->integer(),
            'votes' => $this->integer()->notNull(),
            'PRIMARY KEY(quiz_input_option_id, quiz_voted_result_id)',
        ], $tableOptions);

        // creates index for column `quiz_input_option_id`
        $this->createIndex(
            'idx-quiz_inp_opt_to_voted_result-quiz_inp_opt_id',
            'quiz_input_option_to_voted_result',
            'quiz_input_option_id'
        );

        // add foreign key for table `quiz_input_option`
        $this->addForeignKey(
            'fk-quiz_inp_opt_to_voted_result-quiz_inp_opt_id',
            'quiz_input_option_to_voted_result',
            'quiz_input_option_id',
            'quiz_input_option',
            'id',
            'CASCADE'
        );

        // creates index for column `quiz_voted_result_id`
        $this->createIndex(
            'idx-quiz_inp_opt_to_voted_result-quiz_voted_result_id',
            'quiz_input_option_to_voted_result',
            'quiz_voted_result_id'
        );

        // add foreign key for table `quiz_result`
        $this->addForeignKey(
            'fk-quiz_inp_opt_to_voted_result-quiz_voted_result_id',
            'quiz_input_option_to_voted_result',
            'quiz_voted_result_id',
            'quiz_result',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `quiz_input_option`
        $this->dropForeignKey(
            'fk-quiz_inp_opt_to_voted_result-quiz_inp_opt_id',
            'quiz_input_option_to_voted_result'
        );

        // drops index for column `quiz_input_option_id`
        $this->dropIndex(
            'idx-quiz_inp_opt_to_voted_result-quiz_inp_opt_id',
            'quiz_input_option_to_voted_result'
        );

        // drops foreign key for table `quiz_result`
        $this->dropForeignKey(
            'fk-quiz_inp_opt_to_voted_result-quiz_voted_result_id',
            'quiz_input_option_to_voted_result'
        );

        // drops index for column `quiz_voted_result_id`
        $this->dropIndex(
            'idx-quiz_inp_opt_to_voted_result-quiz_voted_result_id',
            'quiz_input_option_to_voted_result'
        );

        $this->dropTable('quiz_input_option_to_voted_result');
    }
}
