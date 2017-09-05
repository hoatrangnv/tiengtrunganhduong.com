<?php

use yii\db\Migration;

/**
 * Handles adding countdown_delay to table `quiz`.
 */
class m170827_162736_add_countdown_delay_column_to_quiz_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz', 'countdown_delay', $this->integer()->after('duration'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz', 'countdown_delay');
    }
}
