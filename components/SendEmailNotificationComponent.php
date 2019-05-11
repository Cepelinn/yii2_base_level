<?php


namespace app\components;


use app\models\tables\Tasks;
use app\models\tables\Users;
use yii\base\BootstrapInterface;
use yii\base\Component;
use yii\base\Event;
use Yii;

class SendEmailNotificationComponent extends Component implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $this->attachEmailNotificationHandler();
    }

    private function attachEmailNotificationHandler()
    {
        Event::on(Tasks::class, Tasks::EVENT_AFTER_INSERT, function($event){
           $task = $event->sender;
           $user = Users::find()
                    ->select('email')
                    ->where(['id' => $task->responsible_id])
                    ->one();
           $body = "A new <a href='?r=task/view&id={$task->id}'> task </a> had opened at you.";

            Yii::$app->mailer->compose()
                    ->setTo($user->email)
                    ->setFrom(['service@yii.unu.local' => 'Service desc'])
                    ->setSubject($task->name)
                    ->setTextBody($body)
                    ->send();
        });
    }
}