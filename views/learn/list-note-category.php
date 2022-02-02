<?php

use yii\helpers\Html;

?>
<div class="list-group">
    <?php
        foreach($category as $item)
        {
            ?>
                <li class="list-group-item">
                    <?= Html::a($item['title'] . ' List', ['/learn/list-note-detail', 'id_category' => $item['id']], ['class'=>'btn btn-info', 'role' => 'button']); ?>
                    <?= Html::a($item['title'] . ' One Note', ['/learn/list-note-one', 'id_category' => $item['id']], ['class'=>'btn btn-success', 'role' => 'button']); ?>
                    <?= Html::a($item['title'] . ' Groups Theme', ['/learn/list-theme-one', 'id_category' => $item['id']], ['class'=>'btn btn-warning', 'role' => 'button']); ?>
                    <?= Html::a($item['title'] . ' Random Note', ['/learn/random-note', 'id_category' => $item['id']], ['class'=>'btn btn-danger', 'role' => 'button']); ?>
                    <span class="badge badge-primary badge-pill"><?= $item['count_repeat_summ']; ?></span>
                </li>
  
            <?php
        }
        echo Html::a('Повторять старые заметки', ['/learn/list-note-old'], ['class'=>'list-group-item']);
    ?>
</div>