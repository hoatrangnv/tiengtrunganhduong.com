<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_to_character_filter`.
 * Has foreign keys to the tables:
 *
 * - `quiz`
 * - `quiz_filter`
 */
class m170717_064828_create_junction_quiz_and_quiz_character_filter_for_quiz_and_quiz_filter_tables extends Migration
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
        $this->createTable('quiz_to_character_filter', [
            'quiz_id' => $this->integer(),
            'quiz_character_filter_id' => $this->integer(),
            'PRIMARY KEY(quiz_id, quiz_character_filter_id)',
        ], $tableOptions);

        // creates index for column `quiz_id`
        $this->createIndex(
            'idx-quiz_to_chr_filter-quiz_id',
            'quiz_to_character_filter',
            'quiz_id'
        );

        // add foreign key for table `quiz`
        $this->addForeignKey(
            'fk-quiz_to_chr_filter-quiz_id',
            'quiz_to_character_filter',
            'quiz_id',
            'quiz',
            'id',
            'CASCADE'
        );

        // creates index for column `quiz_character_filter_id`
        $this->createIndex(
            'idx-quiz_to_chr_filter-quiz_chr_filter_id',
            'quiz_to_character_filter',
            'quiz_character_filter_id'
        );

        // add foreign key for table `quiz_filter`
        $this->addForeignKey(
            'fk-quiz_to_chr_filter-quiz_chr_filter_id',
            'quiz_to_character_filter',
            'quiz_character_filter_id',
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
        // drops foreign key for table `quiz`
        $this->dropForeignKey(
            'fk-quiz_to_chr_filter-quiz_id',
            'quiz_to_character_filter'
        );

        // drops index for column `quiz_id`
        $this->dropIndex(
            'idx-quiz_to_chr_filter-quiz_id',
            'quiz_to_character_filter'
        );

        // drops foreign key for table `quiz_filter`
        $this->dropForeignKey(
            'fk-quiz_to_chr_filter-quiz_chr_filter_id',
            'quiz_to_character_filter'
        );

        // drops index for column `quiz_character_filter_id`
        $this->dropIndex(
            'idx-quiz_to_chr_filter-quiz_chr_filter_id',
            'quiz_to_character_filter'
        );

        $this->dropTable('quiz_to_character_filter');
    }
}
