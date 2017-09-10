<?php

use yii\db\Migration;

/**
 * Handles renaming auto_next column to should_auto_next in table `quiz_input`.
 */
class m170911_110000_rename_auto_next_column_to_should_auto_next_in_quiz_input_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->renameColumn('quiz_input', 'auto_next', 'should_auto_next');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->renameColumn('quiz_input', 'should_auto_next', 'auto_next');
    }
}
