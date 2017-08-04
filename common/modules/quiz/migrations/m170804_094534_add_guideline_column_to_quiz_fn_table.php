<?php

use yii\db\Migration;

/**
 * Handles adding guideline to table `quiz_fn`.
 */
class m170804_094534_add_guideline_column_to_quiz_fn_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz_fn', 'guideline', $this->text());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz_fn', 'guideline');
    }
}
