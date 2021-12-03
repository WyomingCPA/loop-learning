<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
?>
<div class="jumbotron">
  <h1><?= $model->title ?></h1>
  <p><?= $model->last_update ?></p>
  <p><a class="btn btn-primary btn-lg" role="button" target = "_blank" href="<?= $model->link ?>">Читать</a></p>

  <?=Html::beginForm(['learn/learn-random-repeat'], 'post');?>
        <input  type="hidden" name="learn" value="<?= $model->id ?>">
        <?=Html::submitButton('Прочитал', ['class'=>'btn btn-primary btn-lg', 'role' =>'button']);?>
    <?= Html::endForm();?> 
</div>
<div class ="row">
    <p><?= Html::a('Добавить заметки к этой статье', ['learn/add-note', 'id_learn' => $model->id], ['class'=>'btn btn-primary btn-lg', 'target' => '_blank']) ?></p>
    <p><?= Html::a('Заметки к статье', ['learn/list-note', 'id_learn' => $model->id], ['class'=>'btn btn-primary btn-lg', 'target' => '_blank']) ?></p>  
</div>

<?php

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
<p><?= Html::a('Добавить заметки к этой статье', ['learn/add-note', 'id_learn' => $model->id], ['class'=>'btn btn-primary btn-lg', 'target' => '_blank']) ?></p> 
<?php

foreach ($dataProvider->models as $model) {
       
    echo "<div class='shift panel panel-primary'>";
        echo "<div class = 'panel-heading'>";
            //echo "";
            echo "<h3 class ='panel-title'><input class='form-check-input' type='checkbox' name='selection[]' value='{$model->id}'>" . Html::a('', Url::to(['learn/note-update', 'id' => $model->id])) . " <b>{$model->last_update}</b> - Count = <b>{$model->count}</b></h3>";
        echo "</div>";
        echo "<div class='panel-body'><p>{$model->title}</p>";
        echo "</div>";
    echo "</div>";
}

?>

</div>
<?=Html::submitButton('Применить', ['class' => 'btn btn-info',]); ?>

<?= Html::endForm(); ?>