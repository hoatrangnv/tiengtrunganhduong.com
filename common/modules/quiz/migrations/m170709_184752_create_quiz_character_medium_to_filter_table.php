<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_character_medium_to_filter`.
 * Has foreign keys to the tables:
 *
 * - `quiz_character_medium`
 * - `quiz_filter`
 */
class m170709_184752_create_quiz_character_medium_to_filter_table extends Migration
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
        $this->createTable('quiz_character_medium_to_filter', [
            'id' => $this->primaryKey(),
            'character_medium_id' => $this->integer()->notNull(),
            'filter_id' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `character_medium_id`
        $this->createIndex(
            'idx-quiz_character_medium_to_filter-character_medium_id',
            'quiz_character_medium_to_filter',
            'character_medium_id'
        );

        // add foreign key for table `quiz_character_medium`
        $this->addForeignKey(
            'fk-quiz_character_medium_to_filter-character_medium_id',
            'quiz_character_medium_to_filter',
            'character_medium_id',
            'quiz_character_medium',
            'id',
            'CASCADE'
        );

        // creates index for column `filter_id`
        $this->createIndex(
            'idx-quiz_character_medium_to_filter-filter_id',
            'quiz_character_medium_to_filter',
            'filter_id'
        );

        // add foreign key for table `quiz_filter`
        $this->addForeignKey(
            'fk-quiz_character_medium_to_filter-filter_id',
            'quiz_character_medium_to_filter',
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
        // drops foreign key for table `quiz_character_medium`
        $this->dropForeignKey(
            'fk-quiz_character_medium_to_filter-character_medium_id',
            'quiz_character_medium_to_filter'
        );

        // drops index for column `character_medium_id`
        $this->dropIndex(
            'idx-quiz_character_medium_to_filter-character_medium_id',
            'quiz_character_medium_to_filter'
        );

        // drops foreign key for table `quiz_filter`
        $this->dropForeignKey(
            'fk-quiz_character_medium_to_filter-filter_id',
            'quiz_character_medium_to_filter'
        );

        // drops index for column `filter_id`
        $this->dropIndex(
            'idx-quiz_character_medium_to_filter-filter_id',
            'quiz_character_medium_to_filter'
        );

        $this->dropTable('quiz_character_medium_to_filter');
    }
}
