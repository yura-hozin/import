<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\import\AdminImportTmp */

$this->title = 'Create Admin Import Tmp';
$this->params['breadcrumbs'][] = ['label' => 'Admin Import Tmps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-import-tmp-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
