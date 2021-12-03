<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LoopLearn */

$this->title = 'Create Loop Learn';
$this->params['breadcrumbs'][] = ['label' => 'Loop Learns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loop-learn-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
