<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_character_to_sorter`.
 * Has foreign keys to the tables:
 *
 * - `quiz_character`
 * - `quiz_sorter`
 */
class m170717_064753_create_junction_quiz_character_and_quiz_sorter_for_quiz_character_and_quiz_sorter_tables extends Migration
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
        $this->createTable('quiz_character_to_sorter', [
            'quiz_character_id' => $this->integer(),
            'quiz_sorter_id' => $this->integer(),
            'sorter_order' => $this->integer()->notNull(),
            'PRIMARY KEY(quiz_character_id, quiz_sorter_id)',
        ], $tableOptions);

        // creates index for column `quiz_character_id`
        $this->createIndex(
            'idx-quiz_chr_to_sorter-quiz_chr_id',
            'quiz_character_to_sorter',
            'quiz_character_id'
        );

        // add foreign key for table `quiz_character`
        $this->addForeignKey(
            'fk-quiz_chr_to_sorter-quiz_chr_id',
            'quiz_character_to_sorter',
            'quiz_character_id',
            'quiz_character',
            'id',
            'CASCADE'
        );

        // creates index for column `quiz_sorter_id`
        $this->createIndex(
            'idx-quiz_chr_to_sorter-quiz_sorter_id',
            'quiz_character_to_sorter',
            'quiz_sorter_id'
        );

        // add foreign key for table `quiz_sorter`
        $this->addForeignKey(
            'fk-quiz_chr_to_sorter-quiz_sorter_id',
            'quiz_character_to_sorter',
            'quiz_sorter_id',
            'quiz_sorter',
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
            'fk-quiz_chr_to_sorter-quiz_chr_id',
            'quiz_character_to_sorter'
        );

        // drops index for column `quiz_character_id`
        $this->dropIndex(
            'idx-quiz_chr_to_sorter-quiz_chr_id',
            'quiz_character_to_sorter'
        );

        // drops foreign key for table `quiz_sorter`
        $this->dropForeignKey(
            'fk-quiz_chr_to_sorter-quiz_sorter_id',
            'quiz_character_to_sorter'
        );

        // drops index for column `quiz_sorter_id`
        $this->dropIndex(
            'idx-quiz_chr_to_sorter-quiz_sorter_id',
            'quiz_character_to_sorter'
        );

        $this->dropTable('quiz_character_to_sorter');
    }
}
