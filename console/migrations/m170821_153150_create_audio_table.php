<?php

use yii\db\Migration;

/**
 * Handles the creation of table `audio`.
 * Has foreign keys to the tables:
 *
 * - `user`
 * - `user`
 */
class m170821_153150_create_audio_table extends Migration
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
        $this->createTable('audio', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'path' => $this->string(),
            'file_basename' => $this->string()->notNull()->unique(),
            'file_extension' => $this->string()->notNull(),
            'mime_type' => $this->string()->notNull(),
            'duration' => $this->integer(),
            'quality' => $this->integer(),
            'create_time' => $this->integer()->notNull(),
            'update_time' => $this->integer(),
            'creator_id' => $this->integer()->notNull(),
            'updater_id' => $this->integer(),
        ], $tableOptions);

        // creates index for column `creator_id`
        $this->createIndex(
            'idx-audio-creator_id',
            'audio',
            'creator_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-audio-creator_id',
            'audio',
            'creator_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `updater_id`
        $this->createIndex(
            'idx-audio-updater_id',
            'audio',
            'updater_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-audio-updater_id',
            'audio',
            'updater_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-audio-creator_id',
            'audio'
        );

        // drops index for column `creator_id`
        $this->dropIndex(
            'idx-audio-creator_id',
            'audio'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-audio-updater_id',
            'audio'
        );

        // drops index for column `updater_id`
        $this->dropIndex(
            'idx-audio-updater_id',
            'audio'
        );

        $this->dropTable('audio');
    }
}
