<?php

use yii\db\Migration;

/**
 * Handles adding retry_if_incorrect to table `quiz_input`.
 */
class m170822_030740_add_retry_if_incorrect_column_to_quiz_input_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz_input', 'retry_if_incorrect', $this->smallInteger(1)->after('auto_next'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz_input', 'retry_if_incorrect');
    }
}
