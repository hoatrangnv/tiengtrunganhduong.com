<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_shape_to_style`.
 * Has foreign keys to the tables:
 *
 * - `quiz_shape`
 * - `quiz_style`
 */
class m170709_175006_create_quiz_shape_to_style_table extends Migration
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
        $this->createTable('quiz_shape_to_style', [
            'id' => $this->primaryKey(),
            'style_order' => $this->integer(),
            'shape_id' => $this->integer()->notNull(),
            'style_id' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `shape_id`
        $this->createIndex(
            'idx-quiz_shape_to_style-shape_id',
            'quiz_shape_to_style',
            'shape_id'
        );

        // add foreign key for table `quiz_shape`
        $this->addForeignKey(
            'fk-quiz_shape_to_style-shape_id',
            'quiz_shape_to_style',
            'shape_id',
            'quiz_shape',
            'id',
            'CASCADE'
        );

        // creates index for column `style_id`
        $this->createIndex(
            'idx-quiz_shape_to_style-style_id',
            'quiz_shape_to_style',
            'style_id'
        );

        // add foreign key for table `quiz_style`
        $this->addForeignKey(
            'fk-quiz_shape_to_style-style_id',
            'quiz_shape_to_style',
            'style_id',
            'quiz_style',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `quiz_shape`
        $this->dropForeignKey(
            'fk-quiz_shape_to_style-shape_id',
            'quiz_shape_to_style'
        );

        // drops index for column `shape_id`
        $this->dropIndex(
            'idx-quiz_shape_to_style-shape_id',
            'quiz_shape_to_style'
        );

        // drops foreign key for table `quiz_style`
        $this->dropForeignKey(
            'fk-quiz_shape_to_style-style_id',
            'quiz_shape_to_style'
        );

        // drops index for column `style_id`
        $this->dropIndex(
            'idx-quiz_shape_to_style-style_id',
            'quiz_shape_to_style'
        );

        $this->dropTable('quiz_shape_to_style');
    }
}
