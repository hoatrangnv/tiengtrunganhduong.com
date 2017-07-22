<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_input_group`.
 * Has foreign keys to the tables:
 *
 * - `quiz`
 */
class m170716_111130_create_quiz_input_group_table extends Migration
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
        $this->createTable('quiz_input_group', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'title' => $this->string(),
            'global_exec_order' => $this->integer()->notNull(),
            'quiz_id' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `quiz_id`
        $this->createIndex(
            'idx-quiz_input_group-quiz_id',
            'quiz_input_group',
            'quiz_id'
        );

        // add foreign key for table `quiz`
        $this->addForeignKey(
            'fk-quiz_input_group-quiz_id',
            'quiz_input_group',
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
            'fk-quiz_input_group-quiz_id',
            'quiz_input_group'
        );

        // drops index for column `quiz_id`
        $this->dropIndex(
            'idx-quiz_input_group-quiz_id',
            'quiz_input_group'
        );

        $this->dropTable('quiz_input_group');
    }
}
