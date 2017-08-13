<?php

use yii\db\Migration;

/**
 * Handles adding shuffle_options to table `quiz_input`.
 */
class m170813_031311_add_shuffle_options_column_to_quiz_input_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz_input', 'shuffle_options', $this->smallInteger(1)->after('answer_explanation'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz_input', 'shuffle_options');
    }
}
