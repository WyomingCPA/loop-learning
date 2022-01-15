<?php

use yii\helpers\Html;

?>
<div class="list-group">
    <?php
        foreach($category as $item)
        {
            echo Html::a($item['title'] . ' - ' . $item['last_update'] . ' Count- ' . $item['count'] . ' Последнее обновление - ' . $item['last_update'], ['/learn/random-repeat', 'id_category' => $item['id']], ['class'=>'list-group-item']);
        }
    ?>
</div>