<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_fn`.
 */
class m170709_174724_create_quiz_fn_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('quiz_fn', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'params' => $this->string()->notNull(),
            'body' => $this->text()->notNull(),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('quiz_fn');
    }
}
