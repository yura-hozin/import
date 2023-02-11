<?php
use yii\bootstrap5\Html;
?>
<?= Html::a('Страничка Импорта', ['/import'], ['class' => 'btn btn-primary']) ?>

<h1>Настройки Импорта</h1>

<div>Файл конфигурации ищется по этому пути: '<b>/backend/config/import.php</b>'</div>
<p>В конфиге в params должен быть параметр: <b>dir_import</b> в котором будет хранится путь для файлов импорта. Получить значение Yii::$app->params['dir_import']</p>