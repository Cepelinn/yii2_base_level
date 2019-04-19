<?php

namespace app\models;

use app\components\validators\StatusValidator;
use yii\base\Model;

class Task extends Model
{
    public $title;
    public $description;
    public $autor;
    public $responsible;
    public $status;

    public function rules()
    {
        return [
            [['title', 'description', 'responsible'], 'required'],
            ['status', StatusValidator::className()],
            ['autor', 'safe']
        ];
    }
}