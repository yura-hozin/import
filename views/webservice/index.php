<?php

use yii\helpers\ArrayHelper;

if (!isset($info) || (!is_object($info)))
{
    ?>
    <div class="error">Ошибка! Нет соединения с web-сервисом.</div>
    <?php
    return;
}

if (isset($info))
{
    $active = '';
    $active = (ArrayHelper::getValue($info, 'active', 0)) ? "Активен" : "Не активен!";
    $task_key = ArrayHelper::getValue($info, 'task_export', 0);
    $task = ($task_key) ? "Задача установлена!" : "Нет активных задач!";

}
else echo "<div>Ответ от сервера пустой или нет соединения с web-сервисом</div>";
?>

    <h1>Страница связи с Web-сервисом</h1>

    <div class="card">

        <div class="row card-body">
            <div class="col-md-6">Активность Вашего аккаунта на web-сервисе:</div>
            <div class="col-md-6 b i"><?=$active?></div>
        </div>
        <div class="row card-body">
            <div class="col-md-6">Выгружать цену по товарам:</div>
            <div class="col-md-6 b i"><?=ArrayHelper::getValue($info, 'price', 'нет данных')?></div>
        </div>
        <div class="row card-body">
            <div class="col-md-6">Новые задачи на импорт:</div>
            <div class="col-md-6 b i"><?=$task?></div>
        </div>

        <div class="row card-body">
        <?php
        if (!$task_key):
            ?>
            <form name="web_request" method="post">
                <div>
                    <input type="submit" class="btn btn-info" name="to_import" value="Запрос на импорт данных" />
                </div>
            </form>
        <?php endif; ?>
        </div>
    </div>
