<?php

use yii\db\Migration;

/**
 * Handles adding pen_name to table `user`.
 */
class m190817_053213_add_pen_name_column_to_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user', 'pen_name', $this->string()->after('username'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user', 'pen_name');
    }
}
