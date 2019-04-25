<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m190419_101156_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey()->notNull()->unique(),
            'username' => $this->string(45)->notNull()->unique(),
            'password' => $this->string(32)->notNull(),
            'authKey' => $this->string()->notNull(),
            'accessToken' => $this->string()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }
}
