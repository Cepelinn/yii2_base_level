<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\tables\Task */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-filter-form">
    <?php $form = ActiveForm::begin(['method' => 'get']); ?>
    <div class="form-group">
            <?= $form->field($searchModel, 'deadline')->textInput(['type' => 'month']) ?>

            <?= Html::submitButton(Yii::t('app', 'filter'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>