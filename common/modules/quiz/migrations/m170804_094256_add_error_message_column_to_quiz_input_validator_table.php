<?php

use yii\db\Migration;

/**
 * Handles adding error_message to table `quiz_input_validator`.
 */
class m170804_094256_add_error_message_column_to_quiz_input_validator_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz_input_validator', 'error_message', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz_input_validator', 'error_message');
    }
}
