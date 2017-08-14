<?php

use yii\db\Migration;

/**
 * Handles adding view_count_column_like_count_column_comment_count_column_share_count to table `quiz`.
 */
class m170814_174731_add_view_count_column_like_count_column_comment_count_column_share_count_column_to_quiz_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz', 'view_count', $this->integer()->defaultValue(0));
        $this->addColumn('quiz', 'like_count', $this->integer()->defaultValue(0));
        $this->addColumn('quiz', 'comment_count', $this->integer()->defaultValue(0));
        $this->addColumn('quiz', 'share_count', $this->integer()->defaultValue(0));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz', 'view_count');
        $this->dropColumn('quiz', 'like_count');
        $this->dropColumn('quiz', 'comment_count');
        $this->dropColumn('quiz', 'share_count');
    }
}
