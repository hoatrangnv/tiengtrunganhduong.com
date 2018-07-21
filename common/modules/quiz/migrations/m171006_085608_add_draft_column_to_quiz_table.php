<?php

use yii\db\Migration;

/**
 * Handles adding draft to table `quiz`.
 */
class m171006_085608_add_draft_column_to_quiz_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz', 'draft', $this->smallInteger(1)->after('introduction'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz', 'draft');
    }
}
