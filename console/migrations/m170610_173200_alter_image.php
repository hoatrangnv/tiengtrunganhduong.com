<?php

use yii\db\Migration;

class m170610_173200_alter_image extends Migration
{
    public function up()
    {
        $table = '{{%image}}';
        if ($this->db->schema->getTableSchema($table, true) !== null) {
            try {
                $this->alterColumn($table, 'width', $this->integer()->notNull());
                $this->alterColumn($table, 'height', $this->integer()->notNull());
            } catch (\Exception $exception) {
                echo $exception->getMessage() . "\n";
            }
        }
    }

    public function down()
    {
    }
}
