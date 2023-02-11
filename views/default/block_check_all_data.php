<div class="card card-info">
    <div class="card-header card-info">Актуальность данных импорта</div>
    <div class="card-body">

        <table class="table">
            <tr>
                <th>Название</th>
                <th>В файле</th>
                <th>Вр.таблица</th>
                <th>База данных</th>
            </tr>
        <?php
        if (!isset($params)) die();

        $name_type = \backend\modules\import\AdminImportTmp::listType();
        foreach ($params as $key => $param)
        {
            $n_file = (is_countable($param)) ? count($param) : 0;
            $n_tmp = \backend\modules\import\AdminImportTmp::find()->where(['type' => $key])->count();
            $n_db = (isset($count_tables[$key])) ? $count_tables[$key] : 0;
            $class_tmp = ($n_file == $n_tmp) ? "success" : "danger";
            $class_db = ($n_db < $n_file) ? "warning" : "";
        ?>
                <tr>
                    <td><?php echo \yii\helpers\ArrayHelper::getValue($name_type, $key, '???'); ?></td>
                    <td><?php echo $n_file; ?></td>
                    <td class="<?=$class_tmp?>"><?php echo $n_tmp; ?></td>
                    <td class="<?=$class_db?>"><?php echo $n_db; ?></td>
                </tr>
        <?php
        }
        ?>
            <tr>
                <td></td>
                <td></td>
                <td>
                    Красное -> Загрузить из файла.<br>
                    Зеленое -> Все отлично.
                </td>
                <td>
                    Желтое -> Нужен импорт.
                </td>
            </tr>
        </table>
    </div>
</div>

