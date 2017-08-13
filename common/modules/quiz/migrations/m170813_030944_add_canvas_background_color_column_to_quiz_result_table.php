<?php

use yii\db\Migration;

/**
 * Handles adding canvas_background_color to table `quiz_result`.
 */
class m170813_030944_add_canvas_background_color_column_to_quiz_result_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz_result', 'canvas_background_color', $this->string()->after('canvas_height'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz_result', 'canvas_background_color');
    }
}
