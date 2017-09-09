<?php

use yii\db\Migration;

/**
 * Handles dropping inputs_per_rows_column_inputs_per_small_rows_column_inputs_appearance from table `quiz_input_group`.
 */
class m170908_155814_drop_inputs_per_rows_column_inputs_per_small_rows_column_inputs_appearance_column_from_quiz_input_group_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropColumn('quiz_input_group', 'inputs_per_row');
        $this->dropColumn('quiz_input_group', 'inputs_per_small_row');
        $this->dropColumn('quiz_input_group', 'inputs_appearance');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('quiz_input_group', 'inputs_per_row', $this->integer());
        $this->addColumn('quiz_input_group', 'inputs_per_small_row', $this->integer());
        $this->addColumn('quiz_input_group', 'inputs_appearance', $this->string());
    }
}
