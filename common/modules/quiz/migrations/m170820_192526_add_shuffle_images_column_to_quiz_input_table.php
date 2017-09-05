<?php

use yii\db\Migration;

/**
 * Handles adding shuffle_images to table `quiz_input`.
 */
class m170820_192526_add_shuffle_images_column_to_quiz_input_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz_input', 'shuffle_images', $this->smallInteger(1)->after('shuffle_options'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz_input', 'shuffle_images');
    }
}
