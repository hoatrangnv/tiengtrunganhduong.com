<?php

use yii\db\Migration;

/**
 * Handles the creation of table `url_redirection`.
 * Has foreign keys to the tables:
 *
 * - `user`
 * - `user`
 */
class m170713_023859_create_url_redirection_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('url_redirection', [
            'id' => $this->primaryKey(),
            'from_url' => $this->string()->notNull(),
            'to_url' => $this->string()->notNull(),
            'active' => $this->smallInteger(),
            'status' => $this->smallInteger(),
            'type' => $this->smallInteger(),
            'sort_order' => $this->integer(),
            'response_code' => $this->integer()->notNull(),
            'create_time' => $this->integer()->notNull(),
            'update_time' => $this->integer()->notNull(),
            'creator_id' => $this->integer()->notNull(),
            'updater_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `creator_id`
        $this->createIndex(
            'idx-url_redirection-creator_id',
            'url_redirection',
            'creator_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-url_redirection-creator_id',
            'url_redirection',
            'creator_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `updater_id`
        $this->createIndex(
            'idx-url_redirection-updater_id',
            'url_redirection',
            'updater_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-url_redirection-updater_id',
            'url_redirection',
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
            'fk-url_redirection-creator_id',
            'url_redirection'
        );

        // drops index for column `creator_id`
        $this->dropIndex(
            'idx-url_redirection-creator_id',
            'url_redirection'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-url_redirection-updater_id',
            'url_redirection'
        );

        // drops index for column `updater_id`
        $this->dropIndex(
            'idx-url_redirection-updater_id',
            'url_redirection'
        );

        $this->dropTable('url_redirection');
    }
}
