<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_input_to_input_option_filter`.
 * Has foreign keys to the tables:
 *
 * - `quiz_input`
 * - `quiz_filter`
 */
class m170709_184739_create_quiz_input_to_input_option_filter_table extends Migration
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
            'input_id' => $this->integer()->notNull(),
            'filter_id' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `input_id`
        $this->createIndex(
            'idx-quiz_input_to_input_option_filter-input_id',
            'quiz_input_to_input_option_filter',
            'input_id'
        );

        // add foreign key for table `quiz_input`
        $this->addForeignKey(
            'fk-quiz_input_to_input_option_filter-input_id',
            'quiz_input_to_input_option_filter',
            'input_id',
            'quiz_input',
            'id',
            'CASCADE'
        );

        // creates index for column `filter_id`
        $this->createIndex(
            'idx-quiz_input_to_input_option_filter-filter_id',
            'quiz_input_to_input_option_filter',
            'filter_id'
        );

        // add foreign key for table `quiz_filter`
        $this->addForeignKey(
            'fk-quiz_input_to_input_option_filter-filter_id',
            'quiz_input_to_input_option_filter',
            'filter_id',
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
            'fk-quiz_input_to_input_option_filter-input_id',
            'quiz_input_to_input_option_filter'
        );

        // drops index for column `input_id`
        $this->dropIndex(
            'idx-quiz_input_to_input_option_filter-input_id',
            'quiz_input_to_input_option_filter'
        );

        // drops foreign key for table `quiz_filter`
        $this->dropForeignKey(
            'fk-quiz_input_to_input_option_filter-filter_id',
            'quiz_input_to_input_option_filter'
        );

        // drops index for column `filter_id`
        $this->dropIndex(
            'idx-quiz_input_to_input_option_filter-filter_id',
            'quiz_input_to_input_option_filter'
        );

        $this->dropTable('quiz_input_to_input_option_filter');
    }
}
