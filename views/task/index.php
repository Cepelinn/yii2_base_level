<h2>All Tasks</h2>

<?php

use yii\widgets\ListView;

?>

<?=ListView::widget([
    'dataProvider' => $listDataProvider,
    'summary' => false,
    'itemView' => function ($model) {
        return $this->render('_task',['model' => $model]);
    },
])?>