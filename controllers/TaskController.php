<?php

namespace app\controllers;

use app\models\tables\Statuses;
use app\models\tables\Users;
use Yii;
use yii\data\ActiveDataProvider;
use app\models\tables\Tasks;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class TaskController extends Controller
{
    public function actionIndex()
    {

        $query = Tasks::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', ['listDataProvider' => $dataProvider]);
    }

    public function actionView()
    {
        if(isset($_GET['task_id'])){
            $id = $_GET['task_id'];

            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect('?r=task');
            }

            $usersList = Users::find()
                ->select(['username'])
                ->indexBy('id')
                ->column();

            $statusesList = Statuses::find()
                ->select(['title'])
                ->indexBy('id')
                ->column();

            return $this->render('view', [
                'model' => $model,
                'usersList' => $usersList,
                'statusesList' => $statusesList
            ]);
        }
        return $this->actionIndex();
    }

    protected function findModel($id)
    {
        if (($model = Tasks::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
