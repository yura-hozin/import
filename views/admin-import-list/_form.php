<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AdminImportList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-import-list-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date_create')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'date_begin')->textInput() ?>

    <?= $form->field($model, 'date_end')->textInput() ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
