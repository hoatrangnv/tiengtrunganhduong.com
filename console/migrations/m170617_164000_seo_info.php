<?php

use yii\db\Migration;

class m170617_164000_seo_info extends Migration
{
    public function up()
    {
        $table = '{{%seo_info}}';
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            $this->dropColumn($table, 'robots');
            $this->addColumn($table, 'doindex', $this->smallInteger(1));
            $this->addColumn($table, 'dofollow', $this->smallInteger(1));
        }
    }

    public function down()
    {
    }
}
