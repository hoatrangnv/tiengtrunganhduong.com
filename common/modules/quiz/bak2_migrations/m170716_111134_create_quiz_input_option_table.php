<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_input_option`.
 * Has foreign keys to the tables:
 *
 * - `quiz_input`
 */
class m170716_111134_create_quiz_input_option_table extends Migration
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
        $this->createTable('quiz_input_option', [
            'id' => $this->primaryKey(),
            'value' => $this->string()->notNull(),
            'content' => $this->text(),
            'score' => $this->integer(),
            'interpretation' => $this->text(),
            'row' => $this->integer(),
            'column' => $this->integer(),
            'quiz_input_id' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `quiz_input_id`
        $this->createIndex(
            'idx-quiz_input_option-quiz_input_id',
            'quiz_input_option',
            'quiz_input_id'
        );

        // add foreign key for table `quiz_input`
        $this->addForeignKey(
            'fk-quiz_input_option-quiz_input_id',
            'quiz_input_option',
            'quiz_input_id',
            'quiz_input',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `quiz_input`
        $this->dropForeignKey(
            'fk-quiz_input_option-quiz_input_id',
            'quiz_input_option'
        );

        // drops index for column `quiz_input_id`
        $this->dropIndex(
            'idx-quiz_input_option-quiz_input_id',
            'quiz_input_option'
        );

        $this->dropTable('quiz_input_option');
    }
}
