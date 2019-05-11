<?php

namespace app\components\widgets;

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

    public $template = <<<temp
            <div class="col-sm-3">
                <div class="card" style="border: 1px solid grey;border-radius: 5px;padding: 5px; margin: 5px">
                    <div class="card-body">
                        <a href="index.php?r=task/view&task_id={id}"><h5 class="card-title">{name}</h5></a>
                        <p class="card-text">{description}</p>
                        <div style="display: flex; justify-content: space-between">
                            <p class="card-text">{creator}</p>
                            <p class="card-text">{responsible}</p>
                            <p class="card-text">{deadline}</p>
                        </div>
                    </div>
                </div>
            </div>
temp;

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

//        return var_dump($this->creator);
        return strtr($this->template, [
            '{id}' => $this->task->id,
            '{name}' => $this->task->name,
            '{description}' => $this->task->description,
            '{creator}' => $this->creator->username,
            '{responsible}' => $this->responsible->username,
            '{deadline}' => $this->task->deadline ?
                $this->task->deadline : "<span style='color :
                red'>Date not assigned</span>"
        ]);
    }
}