<?php

namespace app\controllers;
use app\models\Task;
use yii\web\Controller;

class TaskController extends Controller
{
    public function actionIndex()
    {
        $model = new Task([
            'title' => 'Yii Task',
            'description' => 'Yii Task description',
            'autor' => 'Levi',
            'responsible' => 'Performer',
            'status' => 'Working'
        ]);

        ob_start();
        var_dump($model->validate());
        $valid = ob_get_clean();
        
        // exit;
        return $this->render('task', [
            'title' => $model->title,
            'description' => $model->description,
            'autor' => $model->autor,
            'responsible' => $model->responsible,
            'status' => $model->status,
            'valid' => $valid
        ]);
    }
}
