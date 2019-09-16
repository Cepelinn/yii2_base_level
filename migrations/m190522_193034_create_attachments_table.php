<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%attachments}}`.
 */
class m190522_193034_create_attachments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%attachments}}', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer()->notNull(),
            'path' => $this->string()->notNull()
        ]);

        $this->addForeignKey(
            'fk-attachmets-task_id',
            'attachments',
            'task_id',
            'tasks',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-attachmets-task_id',
            'attachments');

        $this->dropTable('{{%attachments}}');
    }
}
