<?php

use yii\db\Migration;

/**
 * Handles adding apply_order to table `quiz_character_data_filter`.
 */
class m171015_085810_add_apply_order_column_to_quiz_character_data_filter_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz_character_data_filter', 'apply_order', $this->integer()->notNull()->after('name'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz_character_data_filter', 'apply_order');
    }
}
