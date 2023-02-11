<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\import\AdminImportTmpSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-import-tmp-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'key') ?>

    <?= $form->field($model, 'data') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'create_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
