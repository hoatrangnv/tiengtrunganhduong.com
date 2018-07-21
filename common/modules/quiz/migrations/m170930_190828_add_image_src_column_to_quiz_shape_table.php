<?php

use yii\db\Migration;

/**
 * Handles adding image_src to table `quiz_shape`.
 */
class m170930_190828_add_image_src_column_to_quiz_shape_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz_shape', 'image_src', $this->text()->after('text'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz_shape', 'image_src');
    }
}
