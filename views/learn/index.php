<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\LearnSearch;
/* @var $this yii\web\View */
/* @var $searchModel app\models\LearnSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Loop Learns';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loop-learn-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Loop Learn', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=Html::beginForm(['learn/learn'],'post');?>
    <?=Html::dropDownList('action','',['learn'=>'Выучил',],['class'=>'dropdown',])?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            [
                'attribute' => 'category_id',
                'filter' => $searchModel->categoriesList(),
                'value' => function ($data) {
                    $categoryName = LearnSearch::getCategoryName($data->category_id);
                    return $categoryName->title;
                },
            ],
            'title',
            [
                'attribute' => 'link',
                'value' => function ($data) {
                    return Html::a(Html::encode("Read"), $data->link, ['target'=>'_blank']);
                },                
                'format' => 'raw',
            ],
            [
                'attribute' => 'count_note',
                'value' => function ($data) {
                    $linkText = "";
                    if (!isset($data->count_note))
                    {
                        $linkText = $data->getNotesCount();
                    }
                    else
                    {
                        $linkText = $data->count_note;
                    }

                    return Html::a(Html::encode($linkText), ['learn/list-note', 'id_learn' => $data->id], ['target'=>'_blank']);
                },                
                'format' => 'raw',
            ],
            'count',
            'last_update',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    
<?=Html::submitButton('Выучил', ['class' => 'btn btn-info',]);?>

<?= Html::endForm();?> 


</div>
