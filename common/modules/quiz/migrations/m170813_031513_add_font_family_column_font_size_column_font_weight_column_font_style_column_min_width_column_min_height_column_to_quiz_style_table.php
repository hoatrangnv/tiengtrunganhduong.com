<?php

use yii\db\Migration;

/**
 * Handles adding font_family_column_font_size_column_font_weight_column_font_style_column_min_width_column_min_height to table `quiz_style`.
 */
class m170813_031513_add_font_family_column_font_size_column_font_weight_column_font_style_column_min_width_column_min_height_column_to_quiz_style_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz_style', 'font_family', $this->string()->after('font'));
        $this->addColumn('quiz_style', 'font_size', $this->string()->after('font_family'));
        $this->addColumn('quiz_style', 'font_weight', $this->string()->after('font_size'));
        $this->addColumn('quiz_style', 'font_style', $this->string()->after('font_weight'));
        $this->addColumn('quiz_style', 'min_width', $this->integer()->after('max_height'));
        $this->addColumn('quiz_style', 'min_height', $this->integer()->after('min_width'));

        $this->dropColumn('quiz_style', 'font');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz_style', 'font_family');
        $this->dropColumn('quiz_style', 'font_size');
        $this->dropColumn('quiz_style', 'font_weight');
        $this->dropColumn('quiz_style', 'font_style');
        $this->dropColumn('quiz_style', 'min_width');
        $this->dropColumn('quiz_style', 'min_height');

        $this->addColumn('quiz_style', 'font', $this->string());
    }
}
