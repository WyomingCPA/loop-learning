<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\LoopCategory;
use yii\helpers\ArrayHelper;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model app\models\LoopLearn */
/* @var $form yii\widgets\ActiveForm */


$this->title = 'Create Note';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="loop-learn-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->widget(TinyMce::className(), [
            'options' => ['rows' => 30],
            'language' => 'ru',
            'clientOptions' => [
            'plugins' => [
                'advlist autolink lists link charmap  print hr preview pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen nonbreaking',
                'save insertdatetime media table template paste image codesample'
                ],
                'toolbar' => 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image'
            ]
        ]);
    ?>

    <?= $form->field($learn, 'link')->textInput(['maxlength' => true]) ?>
      

    <div class="form-group">
        <?= Html::submitButton('Add', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>