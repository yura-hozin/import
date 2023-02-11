<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AdminImportList */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Список импортов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="admin-import-list-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'date_create',
            'status',
            'date_begin',
            'date_end',
        ],
    ]) ?>

    <h2>Комментарий к импорту</h2>
    <?php
    $comment = json_decode($model->comment);
    echo "<pre>"; print_r($comment); echo "</pre>";
    ?>

    <div class="row">
        <div class="col-md-4">
            <h3>Категории</h3>
            <div>[category_diff] - Количество записей в наличии и которые нужно сравнить </div>
            <div>[category_new] - Новые записи, нужно добавить</div>
            <div>[category_edit] - Количество записей, которые отличаются, требуется изменить</div>
            <div>[category_new_filter] - Новые записи, но запрещенные к добавлению</div>
            <div>[category_all] - Все записи в импорте</div>
            <div>[category_hide] - Скрыто категорий</div>
        </div>
        <div class="col-md-4">
            <h3>Бренды</h3>
            <div>[brand_diff] - Количество записей в наличии и которые нужно сравнить </div>
            <div>[brand_new] - Новые записи, нужно добавить</div>
            <div>[brand_edit] - Количество записей, которые отличаются, требуется изменить</div>
            <div>[brand_all] - Все записи в импорте</div>
        </div>
        <div class="col-md-4">
            <h3>Товары</h3>
            <div>[product_diff] - Количество записей в наличии и которые нужно сравнить </div>
            <div>[product_new] - Новые записи, нужно добавить</div>
            <div>[product_edit] - Количество записей, которые отличаются, требуется изменить</div>
            <div>[product_all] - Все записи в импорте</div>
        </div>
    </div>
</div>
