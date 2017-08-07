<?php

use yii\db\Migration;

/**
 * Handles adding type to table `quiz_result`.
 */
class m170807_161445_add_type_column_to_quiz_result_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz_result', 'type', $this->string()->notNull()->after('name'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz_result', 'type');
    }
}
