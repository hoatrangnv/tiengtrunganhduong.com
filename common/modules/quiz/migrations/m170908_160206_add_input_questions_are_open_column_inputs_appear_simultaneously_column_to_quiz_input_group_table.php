<?php

use yii\db\Migration;

/**
 * Handles adding input_questions_are_open_column_inputs_appear_simultaneously to table `quiz_input_group`.
 */
class m170908_160206_add_input_questions_are_open_column_inputs_appear_simultaneously_column_to_quiz_input_group_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz_input_group', 'input_questions_are_open', $this->smallInteger(1));
        $this->addColumn('quiz_input_group', 'inputs_appear_simultaneously', $this->smallInteger(1));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz_input_group', 'input_questions_are_open');
        $this->dropColumn('quiz_input_group', 'inputs_appear_simultaneously');
    }
}
