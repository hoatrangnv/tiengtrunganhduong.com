<?php

use yii\db\Migration;

/**
 * Handles adding disable_ads to table `article_category`.
 */
class m181018_103914_add_disable_ads_column_to_article_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('article_category', 'disable_ads', $this->smallInteger(1));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('article_category', 'disable_ads');
    }
}
