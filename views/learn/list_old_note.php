<?php
use yii\helpers\Html;
use yii\helpers\Url;

\yii\web\JqueryAsset::register($this);

$this->registerJs(
    "$('input[type=\"checkbox\"]').click(function(){

        var thischeck = $(this);
             
        if ( thischeck.is(':checked') ) {
         
          thischeck.parent().css( 'background-color', 'red' );
      
          var myVar = setTimeout(myTimer, 60000);
    
        } else {          
            thischeck.parent().css( 'background-color', 'green' );
        }

        function myTimer() {
          thischeck.parent().css( 'background-color', 'green' );
        }
      });"
);

?>

<div class="list-group">

<?=Html::beginForm(['learn/note-done'],'post');?>
<?=Html::dropDownList('action','',['Done'=>'Выполнил', 'Delete'=>'Удалить'],['class'=>'dropdown',])?>

<?php

foreach ($dataProvider->models as $model) {       
    echo "<div class='shift panel panel-primary'>";
        echo "<div class = 'panel-heading'>";
            //echo "";
            echo "<h3 class ='panel-title'><input class='form-check-input' type='checkbox' name='selection[]' value='{$model->id}'>" . Html::a('', Url::to(['learn/note-update', 'id' => $model->id])) . " <b>{$model->last_update}</b> - Count = <b>{$model->count}</b></h3>";
            echo Html::a($model->getLearn()->title, $model->getLearn()->link, ['target'=>'_blank', 'style' => 'background-color:white']);
            
        echo "</div>";
        echo "<div class='panel-body'><p>{$model->title}</p>";
        echo "</div>";
    echo "</div>";
}
?>

</div>
<?=Html::submitButton('Применить', ['class' => 'btn btn-info',]); ?>

<?= Html::endForm(); ?> 