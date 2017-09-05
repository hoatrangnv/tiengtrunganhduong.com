<?php

use yii\db\Migration;

/**
 * Handles adding picture_url_column_first_name_column_last_name_column_gender to table `user`.
 */
class m170819_204841_add_picture_url_column_first_name_column_last_name_column_gender_column_to_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user', 'picture_url', $this->string(1023));
        $this->addColumn('user', 'first_name', $this->string());
        $this->addColumn('user', 'last_name', $this->string());
        $this->addColumn('user', 'gender', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user', 'picture_url');
        $this->dropColumn('user', 'first_name');
        $this->dropColumn('user', 'last_name');
        $this->dropColumn('user', 'gender');
    }
}
