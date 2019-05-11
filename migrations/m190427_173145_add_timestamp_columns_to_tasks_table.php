<?php

use yii\db\Migration;

/**
 * Handles adding timestamp to table `{{%tasks}}`.
 */
class m190427_173145_add_timestamp_columns_to_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%tasks}}',
                        'created_at', $this->timestamp()->defaultValue(NULL));
        $this->addColumn('{{%tasks}}',
                        'updated_at', $this->timestamp()->defaultValue(NULL));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%tasks}}', 'created_at');
        $this->dropColumn('{{%tasks}}', 'updated_at');
    }
}
