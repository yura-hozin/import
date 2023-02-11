<?php

/**
 * Created by PhpStorm.
 * User: Юрий&Елена
 * Date: 11.02.23
 * Time: 19:31
 */

namespace backend\modules\import\models;

use backend\modules\import\i\ImportStrategy;

/**
 * Демонстрационная модель для импорта
 * Class ImportDefaultModel
 * @package backend\modules\import\models
 */
class ImportDefaultModel extends ImportStrategy{

    public function init(){

    }

    public function getType(){
        return 0;
    }

    public function getFieldName(){
        return "default";
    }

    public function getPrimaryKey(){
        return "key";

    }

    /** Запуск импорта */
    public function doRun(){

    }

    /** Отладка импорта одной итерации */
    public function toFix(){

    }

    /** Возвращает кол-во данных в таблице сайта */
    public function getCountDataTable(){
        return 0;
    }
}