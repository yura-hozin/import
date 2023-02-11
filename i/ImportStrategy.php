<?php

namespace backend\modules\import\i;

interface ImportStrategy
{
    public function init();
    public function getType();
    public function getFieldName();
    public function getPrimaryKey();
    /** Запуск импорта */
    public function doRun();
    /** Отладка импорта одной итерации */
    public function toFix();
    /** Возвращает кол-во данных в таблице сайта */
    public function getCountDataTable();
}