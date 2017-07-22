<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_input_group_to_input_filter`.
 * Has foreign keys to the tables:
 *
 * - `quiz_input_group`
 * - `quiz_filter`
 */
class m170709_184733_create_quiz_input_group_to_input_filter_table extends Migration
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

        $this->createTable('quiz_input_group_to_input_filter', [
            'id' => $this->primaryKey(),
            'input_group_id' => $this->integer()->notNull(),
            'input_filter_id' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `input_group_id`
        $this->createIndex(
            'idx-quiz_input_group_to_input_filter-input_group_id',
            'quiz_input_group_to_input_filter',
            'input_group_id'
        );

        // add foreign key for table `quiz_input_group`
        $this->addForeignKey(
            'fk-quiz_input_group_to_input_filter-input_group_id',
            'quiz_input_group_to_input_filter',
            'input_group_id',
            'quiz_input_group',
            'id',
            'CASCADE'
        );

        // creates index for column `input_filter_id`
        $this->createIndex(
            'idx-quiz_input_group_to_input_filter-input_filter_id',
            'quiz_input_group_to_input_filter',
            'input_filter_id'
        );

        // add foreign key for table `quiz_filter`
        $this->addForeignKey(
            'fk-quiz_input_group_to_input_filter-input_filter_id',
            'quiz_input_group_to_input_filter',
            'input_filter_id',
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
        // drops foreign key for table `quiz_input_group`
        $this->dropForeignKey(
            'fk-quiz_input_group_to_input_filter-input_group_id',
            'quiz_input_group_to_input_filter'
        );

        // drops index for column `input_group_id`
        $this->dropIndex(
            'idx-quiz_input_group_to_input_filter-input_group_id',
            'quiz_input_group_to_input_filter'
        );

        // drops foreign key for table `quiz_filter`
        $this->dropForeignKey(
            'fk-quiz_input_group_to_input_filter-input_filter_id',
            'quiz_input_group_to_input_filter'
        );

        // drops index for column `input_filter_id`
        $this->dropIndex(
            'idx-quiz_input_group_to_input_filter-input_filter_id',
            'quiz_input_group_to_input_filter'
        );

        $this->dropTable('quiz_input_group_to_input_filter');
    }
}
