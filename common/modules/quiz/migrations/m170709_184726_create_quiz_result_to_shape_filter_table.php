<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_result_to_shape_filter`.
 * Has foreign keys to the tables:
 *
 * - `quiz_result`
 * - `quiz_filter`
 */
class m170709_184726_create_quiz_result_to_shape_filter_table extends Migration
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
        $this->createTable('quiz_result_to_shape_filter', [
            'id' => $this->primaryKey(),
            'result_id' => $this->integer()->notNull(),
            'filter_id' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `result_id`
        $this->createIndex(
            'idx-quiz_result_to_shape_filter-result_id',
            'quiz_result_to_shape_filter',
            'result_id'
        );

        // add foreign key for table `quiz_result`
        $this->addForeignKey(
            'fk-quiz_result_to_shape_filter-result_id',
            'quiz_result_to_shape_filter',
            'result_id',
            'quiz_result',
            'id',
            'CASCADE'
        );

        // creates index for column `filter_id`
        $this->createIndex(
            'idx-quiz_result_to_shape_filter-filter_id',
            'quiz_result_to_shape_filter',
            'filter_id'
        );

        // add foreign key for table `quiz_filter`
        $this->addForeignKey(
            'fk-quiz_result_to_shape_filter-filter_id',
            'quiz_result_to_shape_filter',
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
        // drops foreign key for table `quiz_result`
        $this->dropForeignKey(
            'fk-quiz_result_to_shape_filter-result_id',
            'quiz_result_to_shape_filter'
        );

        // drops index for column `result_id`
        $this->dropIndex(
            'idx-quiz_result_to_shape_filter-result_id',
            'quiz_result_to_shape_filter'
        );

        // drops foreign key for table `quiz_filter`
        $this->dropForeignKey(
            'fk-quiz_result_to_shape_filter-filter_id',
            'quiz_result_to_shape_filter'
        );

        // drops index for column `filter_id`
        $this->dropIndex(
            'idx-quiz_result_to_shape_filter-filter_id',
            'quiz_result_to_shape_filter'
        );

        $this->dropTable('quiz_result_to_shape_filter');
    }
}
