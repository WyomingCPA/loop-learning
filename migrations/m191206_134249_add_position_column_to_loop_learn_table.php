<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%loop_learn}}`.
 */
class m191206_134249_add_position_column_to_loop_learn_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%loop_learn}}', 'count_note', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%loop_learn}}', 'count_note');
    }
}
