<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\import\models\AdminImportModel */

$this->title = 'Update Admin Import Model: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Admin Import Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="admin-import-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
