<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_input_option_checker`.
 * Has foreign keys to the tables:
 *
 * - `quiz_fn`
 * - `quiz_input_option`
 */
class m170825_015635_create_quiz_input_option_checker_table extends Migration
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
        $this->createTable('quiz_input_option_checker', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'arguments' => $this->string()->notNull(),
            'quiz_fn_id' => $this->integer()->notNull(),
            'quiz_input_option_id' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `quiz_fn_id`
        $this->createIndex(
            'idx-quiz_inp_opt_checker-quiz_fn_id',
            'quiz_input_option_checker',
            'quiz_fn_id'
        );

        // add foreign key for table `quiz_fn`
        $this->addForeignKey(
            'fk-quiz_inp_opt_checker-quiz_fn_id',
            'quiz_input_option_checker',
            'quiz_fn_id',
            'quiz_fn',
            'id',
            'RESTRICT'
        );

        // creates index for column `quiz_input_option_id`
        $this->createIndex(
            'idx-quiz_inp_opt_checker-quiz_inp_opt_id',
            'quiz_input_option_checker',
            'quiz_input_option_id'
        );

        // add foreign key for table `quiz_input_option`
        $this->addForeignKey(
            'fk-quiz_inp_opt_checker-quiz_inp_opt_id',
            'quiz_input_option_checker',
            'quiz_input_option_id',
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
        // drops foreign key for table `quiz_fn`
        $this->dropForeignKey(
            'fk-quiz_inp_opt_checker-quiz_fn_id',
            'quiz_input_option_checker'
        );

        // drops index for column `quiz_fn_id`
        $this->dropIndex(
            'idx-quiz_inp_opt_checker-quiz_fn_id',
            'quiz_input_option_checker'
        );

        // drops foreign key for table `quiz_input_option`
        $this->dropForeignKey(
            'fk-quiz_inp_opt_checker-quiz_inp_opt_id',
            'quiz_input_option_checker'
        );

        // drops index for column `quiz_input_option_id`
        $this->dropIndex(
            'idx-quiz_inp_opt_checker-quiz_inp_opt_id',
            'quiz_input_option_checker'
        );

        $this->dropTable('quiz_input_option_checker');
    }
}
