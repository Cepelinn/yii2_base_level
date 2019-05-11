<?php

namespace app\controllers;

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
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', ['listDataProvider' => $dataProvider]);
    }

    public function actionView()
    {
        if(isset($_GET['task_id'])){
            $id = $_GET['task_id'];

            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }

    }

    protected function findModel($id)
    {
        if (($model = Tasks::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
