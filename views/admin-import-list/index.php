
<?php

use \backend\widgets\Options\OptionsWidget;

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AdminImportListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
Pjax::begin([
    'id' => 'actionChangeOptionAjax'
]);
$this->title = 'Задачи на импорт';
$this->params['breadcrumbs'][] = $this->title;
$statuses = \backend\modules\import\AdminImportList::getStatuses();
$GLOBALS['statuses'] = $statuses;

/**
 * Для опредления цвета по статусу
 * @param $key
 * @return mixed|string
 */
function getStyle($key)
{
    $statuses = $GLOBALS['statuses'];
    return (isset($statuses[$key]) && isset($statuses[$key]['class_style'])) ? $statuses[$key]['class_style'] : '';
}

/**
 * Для опредления названия по статусу
 * @param $key
 * @return mixed|string
 */
function getTitleStatus($key)
{
    $statuses = $GLOBALS['statuses'];
    return (isset($statuses[$key]) && isset($statuses[$key]['title'])) ? $statuses[$key]['title'] : '???';
}

?>

<?= Html::a('Главная страница импорта', ['/import'], ['class' => 'btn btn-primary']) ?>

<div class="admin-import-list-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'date_create',
            [
                'attribute'=>'status',
                'contentOptions' => function($data, $key){
                    return ['class' => getStyle($data['status']).' text-center'];
                },
                'content'=>function($data){
                    return getTitleStatus($data->status);
                }
            ],
            'date_begin',
            'date_end',
            //'comment:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
<?php Pjax::end(); ?>