<?php

use yii\db\Migration;

/**
 * Handles alter index column in table `quiz_character_medium`.
 */
class m171101_164115_alter_index_column_in_quiz_character_medium_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->alterColumn('quiz_character_medium', 'index', $this->string()->notNull());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->alterColumn('quiz_character_medium', 'index', $this->integer()->notNull());
    }
}
