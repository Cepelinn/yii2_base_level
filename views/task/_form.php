<?php

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\tables\Task */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-form single_task">

    <?php $form = ActiveForm::begin();?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

    <div class="single_task__info"><?= $form->field($model, 'creator_id')->dropDownList($usersList, [
            'prompt' => 'Выбирете пользователя'
        ]) ?>

        <?= $form->field($model, 'responsible_id')->dropDownList($usersList, [
            'prompt' => 'Выбирете пользователя'
        ]) ?>

        <?= $form->field($model, 'deadline')->textInput(['type' => 'date']) ?>

        <?= $form->field($model, 'status_id')->dropDownList($statusesList, [
            'prompt' => 'Выбирете статус'
        ]) ?></div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

