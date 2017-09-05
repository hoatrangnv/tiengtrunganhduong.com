<?php

use yii\db\Migration;

/**
 * Handles adding async to table `quiz_fn`.
 */
class m170820_060749_add_async_column_to_quiz_fn_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz_fn', 'async', $this->smallInteger(1)->after('body'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz_fn', 'async');
    }
}
