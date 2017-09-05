<?php

use yii\db\Migration;

/**
 * Handles adding required to table `quiz_input`.
 */
class m170825_023246_add_required_column_to_quiz_input_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz_input', 'required', $this->smallInteger(1)->after('answer_explanation'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz_input', 'required');
    }
}
