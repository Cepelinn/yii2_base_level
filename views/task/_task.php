<?php

use app\components\widgets\TaskView;
use app\models\tables\Tasks;
;

?>

<?=TaskView::widget(['task' => $model])?>