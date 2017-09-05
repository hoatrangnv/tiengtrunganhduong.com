<?php

use yii\db\Migration;

/**
 * Handles alter value column in table `quiz_input`.
 */
class m170825_103246_alter_value_column_in_quiz_input_option_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->alterColumn('quiz_input_option', 'value', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->alterColumn('quiz_input_option', 'value', $this->string()->notNull());
    }
}
