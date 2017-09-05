<?php

use yii\db\Migration;

/**
 * Handles adding countdown_delay to table `quiz_input_group`.
 */
class m170827_163030_add_countdown_delay_column_to_quiz_input_group_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz_input_group', 'countdown_delay', $this->integer()->after('duration'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz_input_group', 'countdown_delay');
    }
}
