<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_input_to_input_option_filter`.
 * Has foreign keys to the tables:
 *
 * - `quiz_input`
 * - `quiz_filter`
 */
class m170716_111216_create_quiz_input_to_input_option_filter_table extends Migration
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
        $this->createTable('quiz_input_to_input_option_filter', [
            'id' => $this->primaryKey(),
            'quiz_input_id' => $this->integer()->notNull(),
            'quiz_input_option_filter_id' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `quiz_input_id`
        $this->createIndex(
            'idx-quiz_inp_to_inp_opt_filter-quiz_input_id',
            'quiz_input_to_input_option_filter',
            'quiz_input_id'
        );

        // add foreign key for table `quiz_input`
        $this->addForeignKey(
            'fk-quiz_inp_to_inp_opt_filter-quiz_input_id',
            'quiz_input_to_input_option_filter',
            'quiz_input_id',
            'quiz_input',
            'id',
            'CASCADE'
        );

        // creates index for column `quiz_input_option_filter_id`
        $this->createIndex(
            'idx-quiz_inp_to_inp_opt_filter-quiz_inp_opt_filter_id',
            'quiz_input_to_input_option_filter',
            'quiz_input_option_filter_id'
        );

        // add foreign key for table `quiz_filter`
        $this->addForeignKey(
            'fk-quiz_inp_to_inp_opt_filter-quiz_inp_opt_filter_id',
            'quiz_input_to_input_option_filter',
            'quiz_input_option_filter_id',
            'quiz_filter',
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
            'fk-quiz_inp_to_inp_opt_filter-quiz_input_id',
            'quiz_input_to_input_option_filter'
        );

        // drops index for column `quiz_input_id`
        $this->dropIndex(
            'idx-quiz_inp_to_inp_opt_filter-quiz_input_id',
            'quiz_input_to_input_option_filter'
        );

        // drops foreign key for table `quiz_filter`
        $this->dropForeignKey(
            'fk-quiz_inp_to_inp_opt_filter-quiz_inp_opt_filter_id',
            'quiz_input_to_input_option_filter'
        );

        // drops index for column `quiz_input_option_filter_id`
        $this->dropIndex(
            'idx-quiz_inp_to_inp_opt_filter-quiz_inp_opt_filter_id',
            'quiz_input_to_input_option_filter'
        );

        $this->dropTable('quiz_input_to_input_option_filter');
    }
}
