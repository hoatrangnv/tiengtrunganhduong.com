<?php

use yii\db\Migration;

/**
 * Handles the creation of table `missing_word`.
 */
class m180529_150056_create_missing_word_table extends Migration
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
        $this->createTable('missing_word', [
            'id' => $this->primaryKey(),
            'word' => $this->string()->notNull()->unique(),
            'search_count' => $this->integer()->notNull(),
            'last_search_time' => $this->dateTime()->notNull(),
            'status' => $this->smallInteger()->notNull(),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('missing_word');
    }
}
