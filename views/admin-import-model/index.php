<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Все импорты';
$this->params['breadcrumbs'][] = $this->title;
?>

<p>
    <?= Html::a('Импорт', ['/import'], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Загрузить новые', ['/import/admin-import-model/load-new-model'], ['class' => 'btn btn-warning']) ?>
</p>


<div class="admin-import-model-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать запись', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'path',
            'source',
            'active',
            [
                'class' => ActionColumn::className(),
                /*
                'urlCreator' => function ($action, AdminImportModel $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
                */
            ],

        ],
    ]); ?>


</div>
