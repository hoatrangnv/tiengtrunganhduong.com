<?php

use yii\db\Migration;

/**
 * Handles adding timeout_handling to table `quiz_input_group`.
 */
class m170821_194339_add_timeout_handling_column_to_quiz_input_group_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz_input_group', 'timeout_handling', $this->string()->after('duration'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz_input_group', 'timeout_handling');
    }
}
