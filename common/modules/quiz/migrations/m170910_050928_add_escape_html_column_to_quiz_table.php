<?php

use yii\db\Migration;

/**
 * Handles adding escape_html to table `quiz`.
 */
class m170910_050928_add_escape_html_column_to_quiz_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz', 'escape_html', $this->smallInteger(1)->after('introduction'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz', 'escape_html');
    }
}
