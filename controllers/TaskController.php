<?php

namespace app\controllers;

use app\models\forms\TaskAttachmentsAddForm;
use app\components\cache\DbDependencyHelper;
use app\models\filters\MonthTaskFilter;
use app\models\tables\Comments;
use app\models\tables\Statuses;
use app\models\tables\Users;
use Yii;
use yii\data\ActiveDataProvider;
use app\models\tables\Tasks;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class TaskController extends Controller
{
    public function actionIndex()
    {

        $searchModel = new MonthTaskFilter();
        $DataProvider = $searchModel->search(Yii::$app->request->queryParams);

        Yii::$app->getDb()->cache(function ($db) use ($DataProvider) {
            $DataProvider->prepare();
        }, 60 * 60, DbDependencyHelper::generateDependency(Tasks::find()));

        return $this->render('index', [
            'searchModel' => $searchModel,
            'listDataProvider' => $DataProvider,
        ]);
    }

    public function actionView()
    {
        if (Yii::$app->request->get('task_id')) {
            $id = Yii::$app->request->get('task_id');

            $model = $this->findModel($id);

            $commentModel = new Comments();

            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->imageFile && $model->upload()) {
                $filename = $model->imageFile->name;
                $model->img_fullpath = Yii::getAlias("@web/{$model->getRootRelativePath()}{$filename}");
                $model->img_thumbpath = Yii::getAlias("@web/{$model->getRootRelativePath()}thumbs/{$filename}");
            }

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Изменения сохранены');
                return $this->redirect(Yii::$app->request->referrer);
            }

            if ($commentModel->load(Yii::$app->request->post()) && $commentModel->save()) {
                Yii::$app->session->setFlash('success', 'Комментарий успешно опубликован');
                return $this->redirect(Yii::$app->request->referrer);
            }

            $usersList = Users::find()
                ->select(['username'])
                ->indexBy('id')
                ->column();

            $statusesList = Statuses::find()
                ->select(['title'])
                ->indexBy('id')
                ->column();

            $commentsListDataProvider = new ActiveDataProvider([
                'query' => Comments::find()->where(['task_id' => $id])
            ]);

            return $this->render('view', [
                'model' => $model,
                'usersList' => $usersList,
                'statusesList' => $statusesList,
                'commentsListDataProvider' => $commentsListDataProvider,
                'commentModel' => $commentModel,
                'taskAttachmentForm' => new TaskAttachmentsAddForm()
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

    public function actionAddAttachment()
    {
        $model = new TaskAttachmentsAddForm();
        $model->load(\Yii::$app->request->post());
        $model->attachment = UploadedFile::getInstance($model, 'attachment');
        if ($model->save()) {
            \Yii::$app->session->setFlash('success', "Файл добавлен!");
        } else {
            \Yii::$app->session->setFlash('error', "Не удалось добавить Файл");
        }
        $this->redirect(\Yii::$app->request->referrer);
    }
}
