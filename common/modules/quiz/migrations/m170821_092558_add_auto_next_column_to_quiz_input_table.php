<?php

use yii\db\Migration;

/**
 * Handles adding auto_next to table `quiz_input`.
 */
class m170821_092558_add_auto_next_column_to_quiz_input_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz_input', 'auto_next', $this->smallInteger(1)->after('shuffle_images'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz_input', 'auto_next');
    }
}
