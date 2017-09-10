<?php

use yii\db\Migration;

/**
 * Handles alter value column in table `quiz_input`.
 */
class m170911_100000_alter_error_message_column_in_quiz_input_validator_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->alterColumn('quiz_input_validator', 'error_message', $this->string()->notNull()->after('name'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->alterColumn('quiz_input_validator', 'error_message', $this->string());
    }
}
