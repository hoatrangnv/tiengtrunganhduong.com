<?php

use yii\db\Migration;

/**
 * Handles the creation of table `name_translation`.
 */
class m170912_162433_create_name_translation_table extends Migration
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
        $this->createTable('name_translation', [
            'id' => $this->primaryKey(),
            'word' => $this->string()->notNull()->unique(),
            'translated_word' => $this->string()->notNull(),
            'spelling' => $this->string(),
            'meaning' => $this->text(),
            'status' => $this->integer(),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('name_translation');
    }
}
