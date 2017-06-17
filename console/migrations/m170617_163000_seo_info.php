<?php

use yii\db\Migration;

class m170617_163000_seo_info extends Migration
{
    public function up()
    {
        $table = '{{%seo_info}}';
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->addColumn($table, 'robots', $this->string());
        }
    }

    public function down()
    {
    }
}
