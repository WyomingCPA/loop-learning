<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\LoopCategory;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\LoopCategory */
/* @var $form yii\widgets\ActiveForm */

$parentCategory = ArrayHelper::merge([0 => 'Root Category'], ArrayHelper::map(LoopCategory::get(0, LoopCategory::find()->all()), 'id', 'title'));
unset($parentCategory[$model->id]);
?>

<div class="loop-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'parent_id')->dropDownList($parentCategory) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(LoopCategory::getStatusList()) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
