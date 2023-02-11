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
    <div class="col-md-4">
        <?php
        $all_cat = getValB($param, 'all');
        $fact_cat1 = getValB($param, '0');
        $style1 = getStyleBar($fact_cat1, $all_cat);

        $problem = getValB($param, '1');
        //$fact_cat2 = getValB($param, '2');
        $fact_cat2 = $all_cat - $problem;
        $style2 = getStyleBar($fact_cat2, $all_cat);

        $style3 = getStyleBar($problem, 0);
        ?>

        <div class="panel panel-info">
            <div class="panel-heading"><?php echo getValB($param, 'title'); ?></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-9">Количество не обработанных(0):</div>
                    <div class="col-md-3 b import_load_color_<?php echo $style1;?>"><?php echo $fact_cat1."/".$all_cat; ?> </div>
                </div>
                <div class="row">
                    <div class="col-md-9">Количество зависших(1):</div>
                    <div class="col-md-3 b import_load_color_<?php echo $style3;?>"><?php echo $problem; ?></div>
                </div>
                <div class="row">
                    <div class="col-md-9">Количество обработанных:</div>
                    <div class="col-md-3 b import_load_color_<?php echo $style2;?>"><?php echo $fact_cat2."/".$all_cat; ?> </div>
                </div>

                <div class="line-top-10"></div>
                <a href="/admin/import/fix?class=ImportProductModel" style='width:100%' target="_blank" class="btn btn-default">Отладка импорта</a>
            </div>
        </div>
    </div>
    <?php
}
?>