<?php

use yii\db\Migration;

/**
 * Handles renaming answer column to answer_explanation in table `quiz_input`.
 */
class m170810_150000_alter_arguments_column_in_quiz_params_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->alterColumn('quiz_param', 'arguments', $this->text());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->alterColumn('quiz_param', 'arguments', $this->string()->notNull());
    }
}
