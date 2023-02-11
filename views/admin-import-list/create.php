<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AdminImportList */

$this->title = 'Create Admin Import List';
$this->params['breadcrumbs'][] = ['label' => 'Admin Import Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-import-list-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
