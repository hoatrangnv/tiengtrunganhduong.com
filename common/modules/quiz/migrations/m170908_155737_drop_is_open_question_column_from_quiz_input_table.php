<?php

use yii\db\Migration;

/**
 * Handles dropping is_open_question from table `quiz_input`.
 */
class m170908_155737_drop_is_open_question_column_from_quiz_input_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropColumn('quiz_input', 'is_open_question');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('quiz_input', 'is_open_question', $this->smallInteger(1));
    }
}
