<?php

use yii\db\Migration;

/**
 * Handles adding repeat_count to table `quiz_input_option`.
 */
class m170820_154843_add_repeat_count_column_to_quiz_input_option_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz_input_option', 'repeat_count', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz_input_option', 'repeat_count');
    }
}
