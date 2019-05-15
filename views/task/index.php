<a href="?r=task"><h2>All Tasks</h2></a>

<?php

use yii\widgets\ListView;

?>

<?php echo $this->render('_filterForm', [
    'searchModel' => $searchModel,
]); ?>

<?=ListView::widget([
    'dataProvider' => $listDataProvider,
    'summary' => false,
    'itemView' => function ($model) {
        return $this->render('_task',['model' => $model]);
    },
])?>