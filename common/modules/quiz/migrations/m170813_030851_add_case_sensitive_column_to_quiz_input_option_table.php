<?php

use yii\db\Migration;

/**
 * Handles adding case_sensitive to table `quiz_input_option`.
 */
class m170813_030851_add_case_sensitive_column_to_quiz_input_option_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz_input_option', 'case_sensitive', $this->smallInteger(1)->after('correct'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz_input_option', 'case_sensitive');
    }
}
