<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_result`.
 * Has foreign keys to the tables:
 *
 * - `quiz`
 */
class m170724_162050_create_quiz_result_table extends Migration
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
        $this->createTable('quiz_result', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'title' => $this->string(),
            'description' => $this->string(511),
            'content' => $this->text(),
            'priority' => $this->integer(),
            'canvas_width' => $this->integer()->notNull(),
            'canvas_height' => $this->integer()->notNull(),
            'quiz_id' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `quiz_id`
        $this->createIndex(
            'idx-quiz_result-quiz_id',
            'quiz_result',
            'quiz_id'
        );

        // add foreign key for table `quiz`
        $this->addForeignKey(
            'fk-quiz_result-quiz_id',
            'quiz_result',
            'quiz_id',
            'quiz',
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
            'fk-quiz_result-quiz_id',
            'quiz_result'
        );

        // drops index for column `quiz_id`
        $this->dropIndex(
            'idx-quiz_result-quiz_id',
            'quiz_result'
        );

        $this->dropTable('quiz_result');
    }
}
