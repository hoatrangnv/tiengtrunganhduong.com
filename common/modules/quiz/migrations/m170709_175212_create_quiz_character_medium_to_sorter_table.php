<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_character_medium_to_sorter`.
 * Has foreign keys to the tables:
 *
 * - `quiz_character_medium`
 * - `quiz_sorter`
 */
class m170709_175212_create_quiz_character_medium_to_sorter_table extends Migration
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
        $this->createTable('quiz_character_medium_to_sorter', [
            'id' => $this->primaryKey(),
            'sorter_order' => $this->integer(),
            'character_medium_id' => $this->integer()->notNull(),
            'sorter_id' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `character_medium_id`
        $this->createIndex(
            'idx-quiz_character_medium_to_sorter-character_medium_id',
            'quiz_character_medium_to_sorter',
            'character_medium_id'
        );

        // add foreign key for table `quiz_character_medium`
        $this->addForeignKey(
            'fk-quiz_character_medium_to_sorter-character_medium_id',
            'quiz_character_medium_to_sorter',
            'character_medium_id',
            'quiz_character_medium',
            'id',
            'CASCADE'
        );

        // creates index for column `sorter_id`
        $this->createIndex(
            'idx-quiz_character_medium_to_sorter-sorter_id',
            'quiz_character_medium_to_sorter',
            'sorter_id'
        );

        // add foreign key for table `quiz_sorter`
        $this->addForeignKey(
            'fk-quiz_character_medium_to_sorter-sorter_id',
            'quiz_character_medium_to_sorter',
            'sorter_id',
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
        // drops foreign key for table `quiz_character_medium`
        $this->dropForeignKey(
            'fk-quiz_character_medium_to_sorter-character_medium_id',
            'quiz_character_medium_to_sorter'
        );

        // drops index for column `character_medium_id`
        $this->dropIndex(
            'idx-quiz_character_medium_to_sorter-character_medium_id',
            'quiz_character_medium_to_sorter'
        );

        // drops foreign key for table `quiz_sorter`
        $this->dropForeignKey(
            'fk-quiz_character_medium_to_sorter-sorter_id',
            'quiz_character_medium_to_sorter'
        );

        // drops index for column `sorter_id`
        $this->dropIndex(
            'idx-quiz_character_medium_to_sorter-sorter_id',
            'quiz_character_medium_to_sorter'
        );

        $this->dropTable('quiz_character_medium_to_sorter');
    }
}
