<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\LoopCategory;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\LoopLearn */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loop-learn-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(LoopCategory::get(0, LoopCategory::find()->all()), 'id', 'title')) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'count')->textInput() ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
