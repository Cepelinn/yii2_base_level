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

    <?=ListView::widget([
        'dataProvider' => $commentsListDataProvider,
        'summary' => false,
        'options' => [
                'class ' => 'comments__container'
],
        'itemView' => function ($model) {
            return $this->render('_comments',['model' => $model]);
        },
    ])?>

    <div class="comments__form-add col-md-6">

        <?php $form = ActiveForm::begin();?>

        <?= $form->field($commentModel, 'creator_id')->dropDownList($usersList, [
            'prompt' => 'Выбирете пользователя'
        ]) ?>

        <?= $form->field($commentModel, 'text')->textarea(['maxlength' => true]) ?>

        <?= $form->field($commentModel, 'task_id')
            ->hiddenInput(['value' => $model->id])
            ->label(false)?>


        <div class="form-group">
            <?= Html::submitButton('Publish you comment', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>