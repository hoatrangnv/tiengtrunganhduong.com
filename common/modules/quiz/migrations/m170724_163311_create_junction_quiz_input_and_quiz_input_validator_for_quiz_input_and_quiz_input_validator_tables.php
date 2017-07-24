<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_input_to_input_validator`.
 * Has foreign keys to the tables:
 *
 * - `quiz_input`
 * - `quiz_input_validator`
 */
class m170724_163311_create_junction_quiz_input_and_quiz_input_validator_for_quiz_input_and_quiz_input_validator_tables extends Migration
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
        $this->createTable('quiz_input_to_input_validator', [
            'quiz_input_id' => $this->integer(),
            'quiz_input_validator_id' => $this->integer(),
            'PRIMARY KEY(quiz_input_id, quiz_input_validator_id)',
        ], $tableOptions);

        // creates index for column `quiz_input_id`
        $this->createIndex(
            'idx-quiz_inp_to_inp_validator-quiz_inp_id',
            'quiz_input_to_input_validator',
            'quiz_input_id'
        );

        // add foreign key for table `quiz_input`
        $this->addForeignKey(
            'fk-quiz_inp_to_inp_validator-quiz_inp_id',
            'quiz_input_to_input_validator',
            'quiz_input_id',
            'quiz_input',
            'id',
            'CASCADE'
        );

        // creates index for column `quiz_input_validator_id`
        $this->createIndex(
            'idx-quiz_inp_to_inp_validator-quiz_inp_validator_id',
            'quiz_input_to_input_validator',
            'quiz_input_validator_id'
        );

        // add foreign key for table `quiz_input_validator`
        $this->addForeignKey(
            'fk-quiz_inp_to_inp_validator-quiz_inp_validator_id',
            'quiz_input_to_input_validator',
            'quiz_input_validator_id',
            'quiz_input_validator',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `quiz_input`
        $this->dropForeignKey(
            'fk-quiz_inp_to_inp_validator-quiz_inp_id',
            'quiz_input_to_input_validator'
        );

        // drops index for column `quiz_input_id`
        $this->dropIndex(
            'idx-quiz_inp_to_inp_validator-quiz_inp_id',
            'quiz_input_to_input_validator'
        );

        // drops foreign key for table `quiz_input_validator`
        $this->dropForeignKey(
            'fk-quiz_inp_to_inp_validator-quiz_inp_validator_id',
            'quiz_input_to_input_validator'
        );

        // drops index for column `quiz_input_validator_id`
        $this->dropIndex(
            'idx-quiz_inp_to_inp_validator-quiz_inp_validator_id',
            'quiz_input_to_input_validator'
        );

        $this->dropTable('quiz_input_to_input_validator');
    }
}
