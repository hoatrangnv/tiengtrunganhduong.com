<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_param`.
 * Has foreign keys to the tables:
 *
 * - `quiz`
 */
class m170709_174822_create_quiz_param_table extends Migration
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
        $this->createTable('quiz_param', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'var_name' => $this->string()->notNull(),
            'value_fn_args' => $this->text()->notNull(),
            'value_fn_id' => $this->integer()->notNull(),
            'global_exec_order' => $this->integer()->notNull(),
            'quiz_id' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `value_fn_id`
        $this->createIndex(
            'idx-quiz_param-value_fn_id',
            'quiz_param',
            'value_fn_id'
        );

        // add foreign key for table `quiz_fn`
        $this->addForeignKey(
            'fk-quiz_param-value_fn_id',
            'quiz_param',
            'value_fn_id',
            'quiz_fn',
            'id',
            'CASCADE'
        );

        // creates index for column `quiz_id`
        $this->createIndex(
            'idx-quiz_param-quiz_id',
            'quiz_param',
            'quiz_id'
        );

        // add foreign key for table `quiz`
        $this->addForeignKey(
            'fk-quiz_param-quiz_id',
            'quiz_param',
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
            'fk-quiz_param-value_fn_id',
            'quiz_param'
        );

        // drops index for column `value_fn_id`
        $this->dropIndex(
            'idx-quiz_param-value_fn_id',
            'quiz_param'
        );

        // drops foreign key for table `quiz`
        $this->dropForeignKey(
            'fk-quiz_param-quiz_id',
            'quiz_param'
        );

        // drops index for column `quiz_id`
        $this->dropIndex(
            'idx-quiz_param-quiz_id',
            'quiz_param'
        );

        $this->dropTable('quiz_param');
    }
}
