<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_character_to_filter`.
 * Has foreign keys to the tables:
 *
 * - `quiz_character`
 * - `quiz_filter`
 */
class m170717_064905_create_junction_quiz_character_and_quiz_filter_for_quiz_character_and_quiz_filter_tables extends Migration
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
        $this->createTable('quiz_character_to_filter', [
            'quiz_character_id' => $this->integer(),
            'quiz_filter_id' => $this->integer(),
            'PRIMARY KEY(quiz_character_id, quiz_filter_id)',
        ], $tableOptions);

        // creates index for column `quiz_character_id`
        $this->createIndex(
            'idx-quiz_chr_to_filter-quiz_chr_id',
            'quiz_character_to_filter',
            'quiz_character_id'
        );

        // add foreign key for table `quiz_character`
        $this->addForeignKey(
            'fk-quiz_chr_to_filter-quiz_chr_id',
            'quiz_character_to_filter',
            'quiz_character_id',
            'quiz_character',
            'id',
            'CASCADE'
        );

        // creates index for column `quiz_filter_id`
        $this->createIndex(
            'idx-quiz_chr_to_filter-quiz_filter_id',
            'quiz_character_to_filter',
            'quiz_filter_id'
        );

        // add foreign key for table `quiz_filter`
        $this->addForeignKey(
            'fk-quiz_chr_to_filter-quiz_filter_id',
            'quiz_character_to_filter',
            'quiz_filter_id',
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
        // drops foreign key for table `quiz_character`
        $this->dropForeignKey(
            'fk-quiz_chr_to_filter-quiz_chr_id',
            'quiz_character_to_filter'
        );

        // drops index for column `quiz_character_id`
        $this->dropIndex(
            'idx-quiz_chr_to_filter-quiz_chr_id',
            'quiz_character_to_filter'
        );

        // drops foreign key for table `quiz_filter`
        $this->dropForeignKey(
            'fk-quiz_chr_to_filter-quiz_filter_id',
            'quiz_character_to_filter'
        );

        // drops index for column `quiz_filter_id`
        $this->dropIndex(
            'idx-quiz_chr_to_filter-quiz_filter_id',
            'quiz_character_to_filter'
        );

        $this->dropTable('quiz_character_to_filter');
    }
}
