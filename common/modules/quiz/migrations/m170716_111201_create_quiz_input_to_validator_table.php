<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_input_to_validator`.
 * Has foreign keys to the tables:
 *
 * - `quiz_input`
 * - `quiz_validator`
 */
class m170716_111201_create_quiz_input_to_validator_table extends Migration
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
        $this->createTable('quiz_input_to_validator', [
            'id' => $this->primaryKey(),
            'quiz_input_id' => $this->integer()->notNull(),
            'quiz_validator_id' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `quiz_input_id`
        $this->createIndex(
            'idx-quiz_input_to_validator-quiz_input_id',
            'quiz_input_to_validator',
            'quiz_input_id'
        );

        // add foreign key for table `quiz_input`
        $this->addForeignKey(
            'fk-quiz_input_to_validator-quiz_input_id',
            'quiz_input_to_validator',
            'quiz_input_id',
            'quiz_input',
            'id',
            'CASCADE'
        );

        // creates index for column `quiz_validator_id`
        $this->createIndex(
            'idx-quiz_input_to_validator-quiz_validator_id',
            'quiz_input_to_validator',
            'quiz_validator_id'
        );

        // add foreign key for table `quiz_validator`
        $this->addForeignKey(
            'fk-quiz_input_to_validator-quiz_validator_id',
            'quiz_input_to_validator',
            'quiz_validator_id',
            'quiz_validator',
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
            'fk-quiz_input_to_validator-quiz_input_id',
            'quiz_input_to_validator'
        );

        // drops index for column `quiz_input_id`
        $this->dropIndex(
            'idx-quiz_input_to_validator-quiz_input_id',
            'quiz_input_to_validator'
        );

        // drops foreign key for table `quiz_validator`
        $this->dropForeignKey(
            'fk-quiz_input_to_validator-quiz_validator_id',
            'quiz_input_to_validator'
        );

        // drops index for column `quiz_validator_id`
        $this->dropIndex(
            'idx-quiz_input_to_validator-quiz_validator_id',
            'quiz_input_to_validator'
        );

        $this->dropTable('quiz_input_to_validator');
    }
}
