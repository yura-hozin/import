<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\import\AdminImportTmpSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Временные записи для импорта';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-import-tmp-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать новую запись', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'key',
            'data:ntext',
            'type',
            'status',
            //'comment:ntext',
            //'create_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
