<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_high_score`.
 * Has foreign keys to the tables:
 *
 * - `quiz`
 * - `user`
 */
class m180825_031528_create_junction_table_for_quiz_and_user_tables extends Migration
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
        $this->createTable('quiz_high_score', [
            'quiz_id' => $this->integer(),
            'user_id' => $this->integer(),
            'score' => $this->integer()->notNull(),
            'duration' => $this->float(),
            'time' => $this->integer()->notNull(),
            'PRIMARY KEY(quiz_id, user_id)',
        ], $tableOptions);

        // creates index for column `quiz_id`
        $this->createIndex(
            'idx-quiz_high_score-quiz_id',
            'quiz_high_score',
            'quiz_id'
        );

        // add foreign key for table `quiz`
        $this->addForeignKey(
            'fk-quiz_high_score-quiz_id',
            'quiz_high_score',
            'quiz_id',
            'quiz',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            'idx-quiz_high_score-user_id',
            'quiz_high_score',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-quiz_high_score-user_id',
            'quiz_high_score',
            'user_id',
            'user',
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
            'fk-quiz_high_score-quiz_id',
            'quiz_high_score'
        );

        // drops index for column `quiz_id`
        $this->dropIndex(
            'idx-quiz_high_score-quiz_id',
            'quiz_high_score'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-quiz_high_score-user_id',
            'quiz_high_score'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-quiz_high_score-user_id',
            'quiz_high_score'
        );

        $this->dropTable('quiz_high_score');
    }
}
