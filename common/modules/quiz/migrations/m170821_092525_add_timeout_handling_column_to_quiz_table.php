<?php

use yii\db\Migration;

/**
 * Handles adding timeout_handling to table `quiz`.
 */
class m170821_092525_add_timeout_handling_column_to_quiz_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz', 'timeout_handling', $this->string()->after('duration'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz', 'timeout_handling');
    }
}
