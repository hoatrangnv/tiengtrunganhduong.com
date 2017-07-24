<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quiz_style`.
 * Has foreign keys to the tables:
 *
 * - `quiz`
 */
class m170724_163007_create_quiz_style_table extends Migration
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
        $this->createTable('quiz_style', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'z_index' => $this->integer(),
            'opacity' => $this->integer(),
            'top' => $this->string(),
            'left' => $this->string(),
            'width' => $this->string(),
            'height' => $this->string(),
            'max_width' => $this->string(),
            'max_height' => $this->string(),
            'padding' => $this->string(),
            'background_color' => $this->string(),
            'border_color' => $this->string(),
            'border_width' => $this->string(),
            'border_radius' => $this->string(),
            'font' => $this->string(),
            'line_height' => $this->string(),
            'text_color' => $this->string(),
            'text_align' => $this->string(),
            'text_stroke_color' => $this->string(),
            'text_stroke_width' => $this->string(),
            'quiz_id' => $this->integer(),
        ], $tableOptions);

        // creates index for column `quiz_id`
        $this->createIndex(
            'idx-quiz_style-quiz_id',
            'quiz_style',
            'quiz_id'
        );

        // add foreign key for table `quiz`
        $this->addForeignKey(
            'fk-quiz_style-quiz_id',
            'quiz_style',
            'quiz_id',
            'quiz',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `quiz`
        $this->dropForeignKey(
            'fk-quiz_style-quiz_id',
            'quiz_style'
        );

        // drops index for column `quiz_id`
        $this->dropIndex(
            'idx-quiz_style-quiz_id',
            'quiz_style'
        );

        $this->dropTable('quiz_style');
    }
}
