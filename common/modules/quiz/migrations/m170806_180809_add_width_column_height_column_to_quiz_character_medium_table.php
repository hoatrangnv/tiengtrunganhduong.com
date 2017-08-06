<?php

use yii\db\Migration;

/**
 * Handles adding width_column_height to table `quiz_character_medium`.
 */
class m170806_180809_add_width_column_height_column_to_quiz_character_medium_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz_character_medium', 'width', $this->integer());
        $this->addColumn('quiz_character_medium', 'height', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz_character_medium', 'width');
        $this->dropColumn('quiz_character_medium', 'height');
    }
}
