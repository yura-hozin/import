<?php
use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = 'Импорт данных v3.0';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="modules-default-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-6">
            <?= Html::a('Главная страница импорта', ['/import'], ['class' => 'btn btn-primary']) ?>
        </div>

        <div class="col-md-6">
            <button class="btn btn-warning btn-edit-status-import" data-number="<?php echo ArrayHelper::getValue($info, 'current_number_import'); ?>">Запустить импорт еще раз</button>
        </div>
    </div>

    <div class="line-top-20"></div>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-info">
                <div class="card-header card-primary">Подключенные модули импорта</div>
                <div class="card-body">
                    <?php echo ArrayHelper::getValue($info, 'init_modules_import'); ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-info">
                <div class="card-header card-info">Информация по текущему импорту</div>
                <div class="card-body">
                    <div class="b">Номер импорта: <?php echo ArrayHelper::getValue($info, 'current_number_import'); ?></div>
                    <div class="b">Статус импорта: <span id="status-import"><?php echo ArrayHelper::getValue($info, 'current_status_import'); ?></span></div>
                    <?php echo ArrayHelper::getValue($info, 'info_file_import', '');?>
                </div>
            </div>
        </div>

        <!-- Состояние файла импорта -->

        <div class="col-md-6">
            <?php echo ArrayHelper::getValue($info, 'block_all_data'); ?>
        </div>

        <div class="col-md-6">
            <?php echo ArrayHelper::getValue($info, 'block_check_all_data'); ?>
        </div>
    </div>

    <?php
    if ((isset($info))&&(!empty($info))&&(count($info) > 0))
    {

        ?>
        <div class="row">
            <div class="col-md-12">
                <h2>Состояние временной таблицы</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <!--<a href="/site/import?com=load_data" class="btn btn-info">Загрузка всех данных во временную таблицу</a>-->
                <?= Html::a('Загрузка всех данных во временную таблицу', ['load-data'], ['class' => 'btn btn-info']) ?>
            </div>
            <div class="col-md-4">
                <?= Html::a('Очистить временную таблицу', ['clear-tmp-date'], ['class' => 'btn btn-danger']) ?>
            </div>
            <div class="col-md-4">
                <a class="btn btn-info btn-upload">Обновить данные по интеграциям</a>
            </div>
        </div>

        <div class="line-top-20"></div>

        <div id="contentimports">...</div>

        <div class="row g-2">
            <?php echo ArrayHelper::getValue($info, 'blocks_import');?>
        </div>
        <div class="line-top-10"></div>
        <?php

        if (!empty($info['logs']))
        {
            echo "<h2>Логирование импорта</h2>";
            foreach ($info['logs'] as $log)
            {
                echo "-->".$log."<br>";
            }
        }
    }
    ?>
</div>

<?php
$this->registerJs('
    function loadBlockImport(){
        $.ajax({
            url: "/admin/import/ajax/block-import",
            dataType: "html",
            data: "",
            success: function(data){
                $("#contentimports").html(data);
            },
            error: function () {
                alert("no");
            }
        });
    }

    function editStatusImport($id){
        $.ajax({
            url: "/admin/import/ajax/edit-status-import?id="+$id,
            dataType: "json",
            data: "",
            success: function(data){
                $("#status-import").css("color", "red").html(0);
            },
            error: function () {
                alert("Ошибка в выполнении запроса");
            }
        });
    }

    $(".btn-upload").click(function () {
        $("#contentimports").html("data3");
        loadBlockImport();    
    });
    $(".btn-upload").click();
    
    $(".btn-edit-status-import").click(function () {
        editStatusImport($(this).data("number"));
    });
');
?>