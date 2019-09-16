<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comments}}`.
 */
class m190518_113131_create_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('comments', [
            'id' => $this->primaryKey(),
            'text' => $this->string()->notNull(),
            'task_id' => $this->integer()->notNull(),
            'creator_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()
        ]);

        $this->addForeignKey(
            'fk-comment-task_id',
            'comments',
            'task_id',
            'tasks',
            'id'
        );

        $this->addForeignKey(
            'fk-comment-creator_id',
            'comments',
            'creator_id',
            'users',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-comment-task_id',
            'comments'
        );

        $this->dropForeignKey(
            'fk-comment-creator_id',
            'comments'
        );

        $this->dropTable('comments');
    }
}
