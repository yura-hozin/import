<?php
// Проверка на существование переменной
function getValB($mas, $key)
{
    return (isset($mas[$key]))? $mas[$key] : "";
}

function getStyleBar($d1, $d2)
{
    $style = 0;
    if (($d1 > 0)&&($d1 < $d2)) $style = 1;
    if ($d1 == $d2) $style = 2;
    return $style;
}


if (!isset($params)) die();
foreach ($params as $param)
{
    ?>

    <div class="col-md-3">
        <?php
        $all_cat = getValB($param, 'all');
        $fact_cat1 = getValB($param, '0');
        $style1 = getStyleBar($fact_cat1, $all_cat);

        $fact_cat2 = getValB($param, '2');
        $style2 = getStyleBar($fact_cat2, $all_cat);
        ?>

        <div class="panel panel-info">
            <div class="panel-heading"><?php echo getValB($param, 'title'); ?></div>
            <div class="panel-body">
                <div>Количество не обработанных(0):</div>
                <div class="import_load_color import_load_color_<?php echo $style1;?>"><?php echo $fact_cat1."/".$all_cat; ?> </div>
                <div>Количество зависших(1): <span style='color: red;'><b><?php echo getValB($param, '1');?></b></span></div>
                <div>Количество обработанных(2):</div>
                <div class="import_load_color import_load_color_<?php echo $style2;?>"><?php echo $fact_cat2."/".$all_cat; ?> </div>

                <div class="line-top-10"></div>
                <a href="/site/import?com=import&class=<?php echo getValB($param, 'class');?>" style='width:100%' target="_blank" class="btn btn-info">Импорт (tmp)</a>
                <div class="line-top-10"></div>
                <a href="/site/import?com=tofix&class=<?php echo getValB($param, 'class');?>" style='width:100%' target="_blank" class="btn btn-info">Отладка импорта</a>
                <div class="line-top-10"></div>
                <a href="/site/import?com=clear_status&class=<?php echo getValB($param, 'class');?>" style='width:100%' target="_blank" class="btn btn-info">Обнулить статус</a>
            </div>
        </div>
    </div>
    <?php
}
?>