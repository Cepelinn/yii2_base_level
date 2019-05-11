<?php

namespace app\components\widgets;

use app\models\tables\Statuses;
use yii\base\Widget;
use yii\helpers\Html;
use yii\base\InvalidConfigException;
use app\models\tables\Tasks;
use app\models\tables\Users;

class TaskView extends Widget
{
    public $task;
    public $creator;
    public $responsible;
    public $status;

    public function getCreator()
    {
        $this->creator = Users::find(1);
    }

    public function init()
    {
        parent::init();

        if ($this->task === null) {
            throw new InvalidConfigException('Please specify the "model" property.');
        }

        if (!$this->task instanceof Tasks) {
            throw new InvalidConfigException('Please specify Tasks model');
        }
    }


    public function run()
    {
        $this->creator = Users::findOne($this->task->creator_id);
        $this->responsible = Users::findOne($this->task->responsible_id);
        $this->status = Statuses::findOne($this->task->status_id);

//        return var_dump($this->creator);
        return $this->render('taskPreview', [
            'id' => $this->task->id,
            'status' => $this->status->suffix,
            'name' => $this->task->name,
            'description' => $this->task->description,
            'creator' => $this->creator->username,
            'responsible' => $this->responsible->username,
            'deadline' => $this->task->deadline ?
                $this->task->deadline : "Date not assigned"
        ]);
    }
}