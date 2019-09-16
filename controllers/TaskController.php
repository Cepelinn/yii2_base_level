<?php

namespace app\controllers;

use app\components\cache\DbDependencyHelper;
use app\models\filters\MonthTaskFilter;
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

        $searchModel = new MonthTaskFilter();
        $DataProvider = $searchModel->search(Yii::$app->request->queryParams);

        Yii::$app->getDb()->cache(function ($db) use ($DataProvider){
            $DataProvider->prepare();
        }, 60 * 60, DbDependencyHelper::generateDependency(Tasks::find()));

        return $this->render('index', [
            'searchModel' => $searchModel,
            'listDataProvider' => $DataProvider,
        ]);
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
