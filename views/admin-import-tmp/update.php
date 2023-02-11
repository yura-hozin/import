<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\import\AdminImportTmp */

$this->title = 'Update Admin Import Tmp: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Admin Import Tmps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="admin-import-tmp-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
