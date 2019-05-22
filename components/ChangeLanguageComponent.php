<?php


namespace app\components;



use yii\base\BootstrapInterface;
use yii\base\Component;
use Yii;

class ChangeLanguageComponent extends Component implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $this->setLanguageHandler();
    }

    private function setLanguageHandler()
    {
        if ($lang = Yii::$app->session->get('lang')){
            Yii::$app->language = $lang;
        }
    }
}