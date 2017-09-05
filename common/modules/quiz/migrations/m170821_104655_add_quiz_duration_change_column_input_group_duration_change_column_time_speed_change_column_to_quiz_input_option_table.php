<?php

use yii\db\Migration;

/**
 * Handles adding quiz_duration_change_column_input_group_duration_change_column_time_speed_change to table `quiz_input_option`.
 */
class m170821_104655_add_quiz_duration_change_column_input_group_duration_change_column_time_speed_change_column_to_quiz_input_option_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz_input_option', 'quiz_duration_change', $this->integer()->after('case_sensitive'));
        $this->addColumn('quiz_input_option', 'input_group_duration_change', $this->integer()->after('quiz_duration_change'));
        $this->addColumn('quiz_input_option', 'time_speed_change', $this->integer()->after('input_group_duration_change'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz_input_option', 'quiz_duration_change');
        $this->dropColumn('quiz_input_option', 'input_group_duration_change');
        $this->dropColumn('quiz_input_option', 'time_speed_change');
    }
}
