<?php

use yii\db\Migration;

/**
 * Handles adding return_type to table `quiz_fn`.
 */
class m170910_022356_add_return_type_column_to_quiz_fn_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz_fn', 'return_type', $this->string()->notNull()->after('body'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz_fn', 'return_type');
    }
}
