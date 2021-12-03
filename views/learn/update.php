<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LoopLearn */

$this->title = 'Update Loop Learn: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Loop Learns', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="loop-learn-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
