<?php

use yii\db\Migration;
use mdm\admin\components\Configs;

class m160312_010000_alter_user extends Migration
{

    public function up()
    {
        $userTable = '{{%user}}';

        if ($this->db->schema->getTableSchema($userTable, true) !== null) {
            $this->renameColumn($userTable, 'created_at', 'create_time');
            $this->renameColumn($userTable, 'updated_at', 'update_time');
            $this->addColumn($userTable, 'type', $this->smallInteger()->notNull());
            $this->addColumn($userTable, 'activation_token', $this->string());
        }
    }

    public function down()
    {

    }
}
