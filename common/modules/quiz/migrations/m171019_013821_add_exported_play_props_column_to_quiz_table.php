<?php

use yii\db\Migration;

/**
 * Handles adding exported_play_props to table `quiz`.
 */
class m171019_013821_add_exported_play_props_column_to_quiz_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz', 'exported_play_props', $this->getDb()->getSchema()->createColumnSchemaBuilder('mediumtext'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz', 'exported_play_props');
    }
}
