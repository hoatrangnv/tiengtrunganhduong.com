<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/13/2017
 * Time: 10:18 AM
 */
class m170813_031515_alter_z_index_column_opacity_column_in_quiz_style_table extends \yii\db\Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->alterColumn('quiz_style', 'z_index', $this->string());
        $this->alterColumn('quiz_style', 'opacity', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->alterColumn('quiz_style', 'z_index', $this->integer());
        $this->alterColumn('quiz_style', 'opacity', $this->integer());
    }

}