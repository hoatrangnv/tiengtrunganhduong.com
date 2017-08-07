<?php

use yii\db\Migration;

/**
 * Handles renaming answer column to answer_explanation in table `quiz_input`.
 */
class m170807_230000_rename_answer_column_to_answer_explanation_in_quiz_input_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->renameColumn('quiz_input', 'answer', 'answer_explanation');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->renameColumn('quiz_input', 'answer_explanation', 'answer');
    }
}
