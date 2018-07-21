<?php

use yii\db\Migration;

/**
 * Handles adding type_column_shuffle_results_column_play_count to table `quiz`.
 */
class m171006_025102_add_type_column_shuffle_results_column_play_count_column_to_quiz_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz', 'type', $this->string()->notNull()->after('slug'));
        $this->addColumn('quiz', 'shuffle_results', $this->smallInteger(1)->after('escape_html'));
        $this->addColumn('quiz', 'play_count', $this->integer()->defaultValue(0)->after('view_count'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz', 'type');
        $this->dropColumn('quiz', 'shuffle_results');
        $this->dropColumn('quiz', 'play_count');
    }
}
