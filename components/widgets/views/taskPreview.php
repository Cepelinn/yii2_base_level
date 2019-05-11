<div class="col-sm-4">
    <div class="card task-card task-card__<?=$status?>">
        <div class="card-body">
            <a href="index.php?r=task/view&task_id=<?=$id?>" class="task-card__title"><?=$name?></a>
            <hr class="task-card__divider">
            <p class="card-text"><?=$description?></p>
            <div class="task-card__info-block">
                <p class="card-text task-card__info">Created by: <?=$creator?></p>
                <p class="card-text task-card__info">Contractor: <?=$responsible?></p>
                <p class="card-text task-card__info">Duration: <?=$deadline?></p>
            </div>
        </div>
    </div>
</div>