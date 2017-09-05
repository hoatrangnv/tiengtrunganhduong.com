<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_input_image`.
 * Has foreign keys to the tables:
 *
 * - `quiz_input`
 * - `image`
 */
class m170820_154702_create_quiz_input_image_table extends Migration
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
        $this->createTable('quiz_input_image', [
            'id' => $this->primaryKey(),
            'sort_order' => $this->integer(),
            'quiz_input_id' => $this->integer()->notNull(),
            'image_id' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `quiz_input_id`
        $this->createIndex(
            'idx-quiz_inp_image-quiz_inp_id',
            'quiz_input_image',
            'quiz_input_id'
        );

        // add foreign key for table `quiz_input`
        $this->addForeignKey(
            'fk-quiz_inp_image-quiz_inp_id',
            'quiz_input_image',
            'quiz_input_id',
            'quiz_input',
            'id',
            'CASCADE'
        );

        // creates index for column `image_id`
        $this->createIndex(
            'idx-quiz_inp_image-image_id',
            'quiz_input_image',
            'image_id'
        );

        // add foreign key for table `image`
        $this->addForeignKey(
            'fk-quiz_inp_image-image_id',
            'quiz_input_image',
            'image_id',
            'image',
            'id',
            'RESTRICT'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `quiz_input`
        $this->dropForeignKey(
            'fk-quiz_inp_image-quiz_inp_id',
            'quiz_input_image'
        );

        // drops index for column `quiz_input_id`
        $this->dropIndex(
            'idx-quiz_inp_image-quiz_inp_id',
            'quiz_input_image'
        );

        // drops foreign key for table `image`
        $this->dropForeignKey(
            'fk-quiz_inp_image-image_id',
            'quiz_input_image'
        );

        // drops index for column `image_id`
        $this->dropIndex(
            'idx-quiz_inp_image-image_id',
            'quiz_input_image'
        );

        $this->dropTable('quiz_input_image');
    }
}
