<?php

use yii\db\Migration;

/**
 * Handles adding is_open_question to table `quiz_input`.
 */
class m170805_171949_add_is_open_question_column_to_quiz_input_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz_input', 'is_open_question', $this->smallInteger(1)->after('type'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz_input', 'is_open_question');
    }
}
