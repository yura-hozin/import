<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\import\AdminImportTmp */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-import-tmp-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'key')->textInput() ?>

    <?= $form->field($model, 'data')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'create_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
