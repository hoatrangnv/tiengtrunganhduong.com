<?php

use yii\db\Migration;

/**
 * Handles adding images_per_row_column_images_per_small_row to table `quiz_input`.
 */
class m170820_191931_add_images_per_row_column_images_per_small_row_column_to_quiz_input_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz_input', 'images_per_row', $this->integer()->after('options_per_small_row'));
        $this->addColumn('quiz_input', 'images_per_small_row', $this->integer()->after('images_per_row'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz_input', 'images_per_row');
        $this->dropColumn('quiz_input', 'images_per_small_row');
    }
}
