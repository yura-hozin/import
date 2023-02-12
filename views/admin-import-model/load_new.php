<?php
/**
 * Created by PhpStorm.
 * User: Юрий&Елена
 * Date: 12.02.23
 * Time: 22:47
 */
use yii\bootstrap5\Html;
?>

<p>
    <?= Html::a('Импорт', ['/import'], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Все импорты', ['/import/admin-import-model'], ['class' => 'btn btn-primary']) ?>
</p>

<h1>Загрузка новых моделей импорта</h1>

<div class="row">
    <?php
    foreach ($list as $row){
    ?>
        <div class="col-md-6"><?=$row['path']?></div>
        <div class="col-md-6"><?=$row['comment']?></div>
    <?php
    }
    ?>
</div>