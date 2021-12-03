<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LoopCategory */

$this->title = 'Update Loop Category: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Loop Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="loop-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
