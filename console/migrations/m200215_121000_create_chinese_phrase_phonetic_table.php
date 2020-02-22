<?php

use yii\db\Migration;

/**
 * Handles the creation of table `chinese_phrase_phonetic`.
 */
class m200215_121000_create_chinese_phrase_phonetic_table extends Migration
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
        $this->createTable('chinese_phrase_phonetic', [
            'id' => $this->primaryKey(),
            'type' => $this->tinyInteger()->notNull(), // simplified or traditional or both are true
            'phrase' => $this->string()->notNull(),
            'phonetic' => $this->string()->notNull(),
            'vi_phonetic' => $this->string()->notNull(),
            'meaning' => $this->text()
        ], $tableOptions);
        $this->createIndex('index-phrase', 'chinese_phrase_phonetic', 'phrase', false);
        $this->createIndex('index-phrase-phonetic', 'chinese_phrase_phonetic', ['phrase', 'phonetic'], true);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('index-phrase-phonetic', 'chinese_phrase_phonetic');
        $this->dropIndex('index-phrase', 'chinese_phrase_phonetic');
        $this->dropTable('chinese_phrase_phonetic');
    }
}
