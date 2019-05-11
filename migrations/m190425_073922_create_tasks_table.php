<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tasks}}`.
 */
class m190425_073922_create_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tasks', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'creator_id' => $this->integer()->notNull(),
            'responsible_id' => $this->integer(),
            'deadline' => $this->date(),
            'status_id' => $this->integer()
        ]);

        $this->addForeignKey(
            'fk-task-creator_id',
            'tasks',
            'creator_id',
            'users',
            'id'
        );

        $this->addForeignKey(
            'fk-task-responsible_id',
            'tasks',
            'responsible_id',
            'users',
            'id'
        );

        $this->addForeignKey(
            'fk-task-status_id',
            'tasks',
            'status_id',
            'statuses',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-task-creator_id',
            'tasks'
        );

        $this->dropForeignKey(
            'fk-task-responsible_id',
            'tasks'
        );

        $this->dropForeignKey(
            'fk-task-status_id',
            'statuses'
        );

        $this->dropTable('tasks');
    }
}
