<?php

use yii\db\Migration;

/**
 * Handles alter index column in table `quiz_character`.
 */
class m171101_164120_alter_index_column_in_quiz_character_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->alterColumn('quiz_character', 'index', $this->string()->notNull());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->alterColumn('quiz_character', 'index', $this->integer()->notNull());
    }
}
