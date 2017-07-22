<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_result_to_character_medium`.
 * Has foreign keys to the tables:
 *
 * - `quiz_result`
 * - `quiz_character_medium`
 */
class m170709_175146_create_quiz_result_to_character_medium_table extends Migration
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
        $this->createTable('quiz_result_to_character_medium', [
            'id' => $this->primaryKey(),
            'result_id' => $this->integer()->notNull(),
            'character_medium_id' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `result_id`
        $this->createIndex(
            'idx-quiz_result_to_character_medium-result_id',
            'quiz_result_to_character_medium',
            'result_id'
        );

        // add foreign key for table `quiz_result`
        $this->addForeignKey(
            'fk-quiz_result_to_character_medium-result_id',
            'quiz_result_to_character_medium',
            'result_id',
            'quiz_result',
            'id',
            'CASCADE'
        );

        // creates index for column `character_medium_id`
        $this->createIndex(
            'idx-quiz_result_to_character_medium-character_medium_id',
            'quiz_result_to_character_medium',
            'character_medium_id'
        );

        // add foreign key for table `quiz_character_medium`
        $this->addForeignKey(
            'fk-quiz_result_to_character_medium-character_medium_id',
            'quiz_result_to_character_medium',
            'character_medium_id',
            'quiz_character_medium',
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
            'fk-quiz_result_to_character_medium-result_id',
            'quiz_result_to_character_medium'
        );

        // drops index for column `result_id`
        $this->dropIndex(
            'idx-quiz_result_to_character_medium-result_id',
            'quiz_result_to_character_medium'
        );

        // drops foreign key for table `quiz_character_medium`
        $this->dropForeignKey(
            'fk-quiz_result_to_character_medium-character_medium_id',
            'quiz_result_to_character_medium'
        );

        // drops index for column `character_medium_id`
        $this->dropIndex(
            'idx-quiz_result_to_character_medium-character_medium_id',
            'quiz_result_to_character_medium'
        );

        $this->dropTable('quiz_result_to_character_medium');
    }
}
