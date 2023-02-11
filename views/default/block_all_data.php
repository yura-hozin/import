<div class="card card-info">
    <div class="card-header card-info">Состояние данных импорта (данные по файлу)</div>
    <div class="card-body">
        <?php
        if (!isset($params)) die();
        foreach ($params as $key => $param)
        {
            $n = (is_countable($param)) ? count($param) : 0;

            ?>
                <div class="row">
                    <div class="col-md-3"><?php echo \yii\helpers\ArrayHelper::getValue($name_type, $key, '???');?></div> <div class="col-md-2"><b><?php echo $n;?></b></span></div>
                </div>
            <?php
        }
        ?>
    </div>
</div>


