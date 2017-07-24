<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_character_data_filter`.
 * Has foreign keys to the tables:
 *
 * - `quiz_fn`
 * - `quiz_character`
 */
class m170724_163146_create_quiz_character_data_filter_table extends Migration
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
        $this->createTable('quiz_character_data_filter', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'arguments' => $this->string()->notNull(),
            'quiz_fn_id' => $this->integer()->notNull(),
            'quiz_character_id' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `quiz_fn_id`
        $this->createIndex(
            'idx-quiz_chr_data_filter-quiz_fn_id',
            'quiz_character_data_filter',
            'quiz_fn_id'
        );

        // add foreign key for table `quiz_fn`
        $this->addForeignKey(
            'fk-quiz_chr_data_filter-quiz_fn_id',
            'quiz_character_data_filter',
            'quiz_fn_id',
            'quiz_fn',
            'id',
            'CASCADE'
        );

        // creates index for column `quiz_character_id`
        $this->createIndex(
            'idx-quiz_chr_data_filter-quiz_chr_id',
            'quiz_character_data_filter',
            'quiz_character_id'
        );

        // add foreign key for table `quiz_character`
        $this->addForeignKey(
            'fk-quiz_chr_data_filter-quiz_chr_id',
            'quiz_character_data_filter',
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
        // drops foreign key for table `quiz_fn`
        $this->dropForeignKey(
            'fk-quiz_chr_data_filter-quiz_fn_id',
            'quiz_character_data_filter'
        );

        // drops index for column `quiz_fn_id`
        $this->dropIndex(
            'idx-quiz_chr_data_filter-quiz_fn_id',
            'quiz_character_data_filter'
        );

        // drops foreign key for table `quiz_character`
        $this->dropForeignKey(
            'fk-quiz_chr_data_filter-quiz_chr_id',
            'quiz_character_data_filter'
        );

        // drops index for column `quiz_character_id`
        $this->dropIndex(
            'idx-quiz_chr_data_filter-quiz_chr_id',
            'quiz_character_data_filter'
        );

        $this->dropTable('quiz_character_data_filter');
    }
}
