<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_character_medium_to_filter`.
 * Has foreign keys to the tables:
 *
 * - `quiz_character_medium`
 * - `quiz_filter`
 */
class m170716_111219_create_quiz_character_medium_to_filter_table extends Migration
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
            'quiz_character_medium_id' => $this->integer()->notNull(),
            'quiz_filter_id' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `quiz_character_medium_id`
        $this->createIndex(
            'idx-quiz_chr_md_to_filter-quiz_chr_md_id',
            'quiz_character_medium_to_filter',
            'quiz_character_medium_id'
        );

        // add foreign key for table `quiz_character_medium`
        $this->addForeignKey(
            'fk-quiz_chr_md_to_filter-quiz_chr_md_id',
            'quiz_character_medium_to_filter',
            'quiz_character_medium_id',
            'quiz_character_medium',
            'id',
            'CASCADE'
        );

        // creates index for column `quiz_filter_id`
        $this->createIndex(
            'idx-quiz_chr_md_to_filter-quiz_filter_id',
            'quiz_character_medium_to_filter',
            'quiz_filter_id'
        );

        // add foreign key for table `quiz_filter`
        $this->addForeignKey(
            'fk-quiz_chr_md_to_filter-quiz_filter_id',
            'quiz_character_medium_to_filter',
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
        // drops foreign key for table `quiz_character_medium`
        $this->dropForeignKey(
            'fk-quiz_chr_md_to_filter-quiz_chr_md_id',
            'quiz_character_medium_to_filter'
        );

        // drops index for column `quiz_character_medium_id`
        $this->dropIndex(
            'idx-quiz_chr_md_to_filter-quiz_chr_md_id',
            'quiz_character_medium_to_filter'
        );

        // drops foreign key for table `quiz_filter`
        $this->dropForeignKey(
            'fk-quiz_chr_md_to_filter-quiz_filter_id',
            'quiz_character_medium_to_filter'
        );

        // drops index for column `quiz_filter_id`
        $this->dropIndex(
            'idx-quiz_chr_md_to_filter-quiz_filter_id',
            'quiz_character_medium_to_filter'
        );

        $this->dropTable('quiz_character_medium_to_filter');
    }
}
