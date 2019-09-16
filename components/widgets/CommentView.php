<?php

namespace app\components\widgets;


use app\models\tables\Comments;
use app\models\tables\Users;
use yii\base\InvalidConfigException;
use yii\base\Widget;

class CommentView extends Widget
{
    public $comment;
    public $creator_name;



    public function init()
    {
        parent::init();

        if ($this->comment === null) {
            throw new InvalidConfigException('Please specify the "model" properly.');
        }

        if (!$this->comment instanceof Comments) {
            throw new InvalidConfigException('Please specify Tasks model');
        }

        $this->creator_name = $this->getUsername($this->comment->creator_id);
    }

    public function run()
    {
        return $this->render('commentPreview', [
            'creator' => $this->creator_name,
            'dateTime' => $this->comment->created_at,
            'text' => $this->comment->text
        ]);
    }

    private function getUsername($id)
    {
        $user = Users::find()
            ->select('username')
            ->where(['id' => $id])
            ->one();
        return $user->username;

    }
}