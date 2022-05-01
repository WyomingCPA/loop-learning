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

$this->registerJs('
  $(".get-word").click(function () {
  var id = $(this).attr("id");
            $.ajax({
              url: "' . \yii\helpers\Url::toRoute(['learn/get-words']) . '",
                dataType: "html",
                data: "id="+this.id,
                success: function(data){
                    $("#myModal").modal("show");
                    $("#modal_body").html(data);
                    $("input[type=\"checkbox\"]").click(function(){

                      var thischeck = $(this);
                
                      if ( thischeck.is(":checked") ) {
                
                          var currentRow = $(this).closest("tr");
                          var count = currentRow.find("td:eq(5)").text();
                          thischeck.parents().addClass("danger");
                          if (count % 5 == 0) {                   
                              var myVar = setTimeout(myTimer, 30000);
                          }
                          else
                          {                   
                              var myVar = setTimeout(myTimer, 10000);
                          }
                      } else {          
                         thischeck.parents().removeClass("danger");
                         thischeck.parents().removeClass("success");
                      }
                
                      function myTimer() {
                        thischeck.parents().removeClass("danger");             
                        thischeck.parents().addClass("success");
                      }
                
                    });
                },
                error: function () {
                    $("#conteiner").html("ERROR");
                }
            });
        });
');
$this->title = $category->title;
$this->params['breadcrumbs'][] = ['label' => 'К списку', 'url' => ["/learn?LearnSearch%5Bcategory_id%5D={$category->id}&LearnSearch%5Btitle%5D=&LearnSearch%5Blink%5D=&LearnSearch%5Bcount%5D=&LearnSearch%5Blast_update%5D="]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="list-group">

  <?= Html::beginForm(['learn/note-done'], 'post'); ?>

  <?= Html::dropDownList('action', '', ['Done' => 'Выполнил', 'Delete' => 'Удалить'], ['class' => 'dropdown',]) ?>
  <p><?= Html::a('Добавить заметки к этой статье', ['learn/add-note', 'id_learn' => $model->id], ['class' => 'btn btn-primary btn-lg', 'target' => '_blank']) ?></p>
  <?php

  foreach (array_slice($dataProvider->models, 0, 1) as $model) {
    echo "<div class='shift panel panel-primary'>";
    echo "<div class = 'panel-heading'>";
    //echo "";
    echo "<h3 class ='panel-title'><input class='form-check-input' type='checkbox' name='selection[]' value='{$model->id}'>" . Html::a('', Url::to(['learn/note-update', 'id' => $model->id])) . " <b>{$model->last_update}</b> - Count = <b>{$model->count}</b></h3>";
    echo Html::a($model->getLearn()->title, $model->getLearn()->link, ['target' => '_blank', 'style' => 'background-color:white']);
    echo "</div>";
    echo "<div class='panel-body'><p>{$model->title}</p>";
    echo "<div id='{$model->id}' class='get-word btn btn-info pull-right'>Получить слова</div>";
    echo Html::a('Редактировать', ['learn/update-note', 'id' => $model->id], ['class' => 'btn btn-danger pull-right', 'target' => '_blank']);
    echo "</div>";
    echo "</div>";
  }
  ?>

</div>
<?= Html::submitButton('Применить', ['class' => 'btn btn-info',]); ?>

<?= Html::endForm(); ?>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Words</h4>
      </div>
      <div class="modal-body">
        <table class="table table-condensed">
          <thead>
            <tr>
              <th><input type="checkbox" class="select-on-check-all" name="selection_all" value="1"></th>
              <th>ID</a></th>
              <th>Word</a></th>
              <th>Translation</th>
              <th>Last Update</th>
              <th>Count</th>
            </tr>
          </thead>
          <tbody id="modal_body">
            <tr data-key="793">
              <td><input type="checkbox" id="word"></td>
              <td>793</td>
              <td>everywhere</td>
              <td>везде</td>
              <td>2022-01-31 11:07:27</td>
              <td>1</td>
            </tr>
          </tbody>
        </table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>