<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%statuses}}`.
 */
class m190510_164744_create_statuses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('statuses', [
            'id' => $this->primaryKey(),
            'title' => $this->string(15)->unique()->notNull(),
            'suffix' => $this->string(15)->unique()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('statuses');
    }
}