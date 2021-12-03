<?php
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'xmlFile')->fileInput() ?>

    <button>Загрузить</button>

<?php ActiveForm::end() ?>