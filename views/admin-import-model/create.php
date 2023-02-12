<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\import\models\AdminImportModel */

$this->title = 'Create Admin Import Model';
$this->params['breadcrumbs'][] = ['label' => 'Admin Import Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-import-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
