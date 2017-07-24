<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_character_medium`.
 * Has foreign keys to the tables:
 *
 * - `quiz_character`
 */
class m170716_111122_create_quiz_character_medium_table extends Migration
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
        $this->createTable('quiz_character_medium', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'var_name' => $this->string()->notNull(),
            'type' => $this->string()->notNull(),
            'index' => $this->integer()->notNull(),
            'global_exec_order' => $this->integer()->notNull(),
            'quiz_character_id' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `quiz_character_id`
        $this->createIndex(
            'idx-quiz_chr_md-quiz_character_id',
            'quiz_character_medium',
            'quiz_character_id'
        );

        // add foreign key for table `quiz_character`
        $this->addForeignKey(
            'fk-quiz_chr_md-quiz_character_id',
            'quiz_character_medium',
            'quiz_character_id',
            'quiz_character',
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
            'fk-quiz_chr_md-quiz_character_id',
            'quiz_character_medium'
        );

        // drops index for column `quiz_character_id`
        $this->dropIndex(
            'idx-quiz_chr_md-quiz_character_id',
            'quiz_character_medium'
        );

        $this->dropTable('quiz_character_medium');
    }
}
