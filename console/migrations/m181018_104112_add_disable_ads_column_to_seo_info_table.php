<?php

use yii\db\Migration;

/**
 * Handles adding disable_ads to table `seo_info`.
 */
class m181018_104112_add_disable_ads_column_to_seo_info_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('seo_info', 'disable_ads', $this->smallInteger(1));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('seo_info', 'disable_ads');
    }
}
