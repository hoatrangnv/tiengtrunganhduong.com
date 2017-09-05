<?php

use yii\db\Migration;

/**
 * Handles adding showed_stopwatches to table `quiz`.
 */
class m170828_175239_add_showed_stopwatches_column_to_quiz_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz', 'showed_stopwatches', $this->string()->after('timeout_handling'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz', 'showed_stopwatches');
    }
}
