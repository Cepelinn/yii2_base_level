<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

?>

<div class="tasks-update">

    <?= $this->render('_form', [
        'model' => $model,
        'usersList' => $usersList,
        'statusesList' => $statusesList
    ]) ?>

    <div class="attachments">
        <h3><?= Yii::t('app', 'attachments') ?></h3>
        <?php $form = ActiveForm::begin(["action" => \yii\helpers\Url::to(['task/add-attachment'])])?>
        <?=$form->field($taskAttachmentForm, 'taskId')->hiddenInput(['value' => $model->id])->label(false);?>
        <?=$form->field($taskAttachmentForm, 'attachment')->fileInput()?>
            <?= Html::submitButton(Yii::t('app', 'send'), ['class' => 'btn btn-success'])?>
        <?php ActiveForm::end()?>

        <div class="attachments__list">
            <?php foreach ($model->taskAttachments as $file):?>
                <a href="/img/task/<?=$file->path?>">
                    <img src="/img/task/thumbs/<?=$file->path?>" alt="attachment">
                </a>
            <?php endforeach?>
        </div>

    </div>

    <div class="comments"

        <h3><?= Yii::t('app', 'comments') ?></h3>

        <?= ListView::widget([
            'dataProvider' => $commentsListDataProvider,
            'summary' => false,
            'options' => [
                'class ' => 'comments__container'
            ],
            'itemView' => function ($model) {
                return $this->render('_comments', ['model' => $model]);
            },
        ]) ?>
    </div>


    <?php
    echo "<div class=\"comments__form-add col-md-6\">";

    if (!Yii::$app->user->isGuest) {
        $form = ActiveForm::begin();
        echo $form->field($commentModel, 'text')->textarea(['maxlength' => true]);
        echo $form->field($commentModel, 'task_id')
            ->hiddenInput(['value' => $model->id])
            ->label(false);
        echo $form->field($commentModel, 'creator_id')
            ->hiddenInput(['value' => Yii::$app->user->id])
            ->label(false);
        echo "<div class=\"form-group\">";
        echo Html::submitButton(Yii::t('app', 'publish'), ['class' => 'btn btn-success']);
        echo "</div>";
        ActiveForm::end();
        echo "</div>";
    }
    ?>

</div>