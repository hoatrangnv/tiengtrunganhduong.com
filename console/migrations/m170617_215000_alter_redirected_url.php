<?php

use yii\db\Migration;

class m170617_215000_alter_redirected_url extends Migration
{
    public function up()
    {
        $this->renameTable('redirected_url', 'url_redirection');
    }

    public function down()
    {
    }
}
