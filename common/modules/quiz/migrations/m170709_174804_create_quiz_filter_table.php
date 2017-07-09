<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_filter`.
 * Has foreign keys to the tables:
 *
 * - `quiz`
 */
class m170709_174804_create_quiz_filter_table extends Migration
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
        $this->createTable('quiz_filter', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'condition' => $this->text()->notNull(),
            'quiz_id' => $this->integer(),
        ], $tableOptions);

        // creates index for column `quiz_id`
        $this->createIndex(
            'idx-quiz_filter-quiz_id',
            'quiz_filter',
            'quiz_id'
        );

        // add foreign key for table `quiz`
        $this->addForeignKey(
            'fk-quiz_filter-quiz_id',
            'quiz_filter',
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
        // drops foreign key for table `quiz`
        $this->dropForeignKey(
            'fk-quiz_filter-quiz_id',
            'quiz_filter'
        );

        // drops index for column `quiz_id`
        $this->dropIndex(
            'idx-quiz_filter-quiz_id',
            'quiz_filter'
        );

        $this->dropTable('quiz_filter');
    }
}
