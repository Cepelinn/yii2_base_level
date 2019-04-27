<a href="index.php?r=task"></a>
<?php

use yii\widgets\DetailView;

?>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'name',
        'description',
        'creator_id',
        'responsible_id',
        'deadline',
        'status_id',
    ],
]) ?>