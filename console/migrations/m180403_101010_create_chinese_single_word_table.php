<?php

use yii\db\Migration;

/**
 * Handles the creation of table `name_translation`.
 */
class m180403_101010_create_chinese_single_word_table extends Migration
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
        $this->createTable('chinese_single_word', [
            'id' => $this->primaryKey(),
            'word' => $this->string()->notNull(),
            'meaning' => $this->text()->notNull(),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('chinese_single_word');
    }
}
