<?php


namespace app\commands;

use app\models\tables\Tasks;
use yii\console\Controller;

class TaskController extends Controller
{
    public function actionDeadline()
    {
        $tasks = Tasks::find()
            ->where('DATEDIFF(NOW(), tasks.deadline) <= 1')
            ->with('responsible')
            ->all();

        foreach ($tasks as $task) {
            var_dump($task->responsible->email);
            \Yii::$app->mailer->compose()
//                ->setFrom('service@yii.uni.local')
                ->setTo($tasks->responsible->email)
                ->setSubject('Deadline')
                ->setTextBody('The time of your open task expires.')
                ->send();
        }
    }
}