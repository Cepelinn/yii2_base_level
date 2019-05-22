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