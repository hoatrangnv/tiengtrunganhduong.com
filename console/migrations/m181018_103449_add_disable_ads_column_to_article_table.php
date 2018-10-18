<?php

use yii\db\Migration;

/**
 * Handles adding disable_ads to table `article`.
 */
class m181018_103449_add_disable_ads_column_to_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('article', 'disable_ads', $this->smallInteger(1));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('article', 'disable_ads');
    }
}
