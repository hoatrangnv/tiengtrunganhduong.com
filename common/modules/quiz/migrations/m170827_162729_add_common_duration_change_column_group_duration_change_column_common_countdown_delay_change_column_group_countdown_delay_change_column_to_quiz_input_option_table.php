<?php

use yii\db\Migration;

/**
 * Handles adding common_duration_change_column_group_duration_change_column_common_countdown_delay_change_column_group_countdown_delay_change to table `quiz_input_option`.
 */
class m170827_162729_add_common_duration_change_column_group_duration_change_column_common_countdown_delay_change_column_group_countdown_delay_change_column_to_quiz_input_option_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz_input_option', 'common_duration_change', $this->integer()->after('case_sensitive'));
        $this->addColumn('quiz_input_option', 'group_duration_change', $this->integer()->after('common_duration_change'));
        $this->addColumn('quiz_input_option', 'common_countdown_delay_change', $this->integer()->after('group_duration_change'));
        $this->addColumn('quiz_input_option', 'group_countdown_delay_change', $this->integer()->after('common_countdown_delay_change'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz_input_option', 'common_duration_change');
        $this->dropColumn('quiz_input_option', 'group_duration_change');
        $this->dropColumn('quiz_input_option', 'common_countdown_delay_change');
        $this->dropColumn('quiz_input_option', 'group_countdown_delay_change');
    }
}
