<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_input_validator`.
 * Has foreign keys to the tables:
 *
 * - `quiz_fn`
 * - `quiz`
 */
class m170724_163214_create_quiz_input_validator_table extends Migration
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
        $this->createTable('quiz_input_validator', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'arguments' => $this->string()->notNull(),
            'quiz_fn_id' => $this->integer()->notNull(),
            'quiz_id' => $this->integer(),
        ], $tableOptions);

        // creates index for column `quiz_fn_id`
        $this->createIndex(
            'idx-quiz_inp_validator-quiz_fn_id',
            'quiz_input_validator',
            'quiz_fn_id'
        );

        // add foreign key for table `quiz_fn`
        $this->addForeignKey(
            'fk-quiz_inp_validator-quiz_fn_id',
            'quiz_input_validator',
            'quiz_fn_id',
            'quiz_fn',
            'id',
            'CASCADE'
        );

        // creates index for column `quiz_id`
        $this->createIndex(
            'idx-quiz_inp_validator-quiz_id',
            'quiz_input_validator',
            'quiz_id'
        );

        // add foreign key for table `quiz`
        $this->addForeignKey(
            'fk-quiz_inp_validator-quiz_id',
            'quiz_input_validator',
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
        // drops foreign key for table `quiz_fn`
        $this->dropForeignKey(
            'fk-quiz_inp_validator-quiz_fn_id',
            'quiz_input_validator'
        );

        // drops index for column `quiz_fn_id`
        $this->dropIndex(
            'idx-quiz_inp_validator-quiz_fn_id',
            'quiz_input_validator'
        );

        // drops foreign key for table `quiz`
        $this->dropForeignKey(
            'fk-quiz_inp_validator-quiz_id',
            'quiz_input_validator'
        );

        // drops index for column `quiz_id`
        $this->dropIndex(
            'idx-quiz_inp_validator-quiz_id',
            'quiz_input_validator'
        );

        $this->dropTable('quiz_input_validator');
    }
}
