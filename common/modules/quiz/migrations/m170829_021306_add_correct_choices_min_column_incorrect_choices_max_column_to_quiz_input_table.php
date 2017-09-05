<?php

use yii\db\Migration;

/**
 * Handles adding correct_choices_min_column_incorrect_choices_max to table `quiz_input`.
 */
class m170829_021306_add_correct_choices_min_column_incorrect_choices_max_column_to_quiz_input_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz_input', 'correct_choices_min', $this->integer()->after('retry_if_incorrect'));
        $this->addColumn('quiz_input', 'incorrect_choices_max', $this->integer()->after('correct_choices_min'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz_input', 'correct_choices_min');
        $this->dropColumn('quiz_input', 'incorrect_choices_max');
    }
}
