<?php

use yii\db\Migration;

/**
 * Handles dropping task_order from table `quiz_character_medium`.
 */
class m171101_164110_drop_task_order_column_from_quiz_character_medium_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropColumn('quiz_character_medium', 'task_order');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('quiz_character_medium', 'task_order', $this->integer()->notNull());
    }
}
