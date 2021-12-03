<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LoopCategory */

$this->title = 'Create Loop Category';
$this->params['breadcrumbs'][] = ['label' => 'Loop Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loop-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
