<?php

use yii\db\Migration;

class m170612_230000_create_crawler extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%crawler}}', [
            // Primary key
            'id' => $this->primaryKey(),

            //
            'url' => $this->string()->notNull(),
            'type' => $this->string(),
            'status' => $this->string(),
            'content' => $this->text(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%crawler}}');
    }
}
