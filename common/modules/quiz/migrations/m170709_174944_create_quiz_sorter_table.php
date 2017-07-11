<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_sorter`.
 * Has foreign keys to the tables:
 *
 * - `quiz`
 */
class m170709_174944_create_quiz_sorter_table extends Migration
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
        $this->createTable('quiz_sorter', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'rule_fn_args' => $this->text()->notNull(),
            'rule_fn_id' => $this->integer()->notNull(),
            'quiz_id' => $this->integer(),
        ], $tableOptions);

        // creates index for column `rule_fn_id`
        $this->createIndex(
            'idx-quiz_sorter-rule_fn_id',
            'quiz_sorter',
            'rule_fn_id'
        );

        // add foreign key for table `quiz_fn`
        $this->addForeignKey(
            'fk-quiz_sorter-rule_fn_id',
            'quiz_sorter',
            'rule_fn_id',
            'quiz_fn',
            'id',
            'CASCADE'
        );

        // creates index for column `quiz_id`
        $this->createIndex(
            'idx-quiz_sorter-quiz_id',
            'quiz_sorter',
            'quiz_id'
        );

        // add foreign key for table `quiz`
        $this->addForeignKey(
            'fk-quiz_sorter-quiz_id',
            'quiz_sorter',
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
        // drops foreign key for table `quiz_fn`
        $this->dropForeignKey(
            'fk-quiz_sorter-rule_fn_id',
            'quiz_sorter'
        );

        // drops index for column `rule_fn_id`
        $this->dropIndex(
            'idx-quiz_sorter-rule_fn_id',
            'quiz_sorter'
        );

        // drops foreign key for table `quiz`
        $this->dropForeignKey(
            'fk-quiz_sorter-quiz_id',
            'quiz_sorter'
        );

        // drops index for column `quiz_id`
        $this->dropIndex(
            'idx-quiz_sorter-quiz_id',
            'quiz_sorter'
        );

        $this->dropTable('quiz_sorter');
    }
}
