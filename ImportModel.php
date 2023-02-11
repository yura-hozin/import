<?php

namespace backend\modules\import;

use Yii;
use backend\modules\import\ImportStrategy;


/**
 * Class ImportModel
 * Модуль для мониторинга данных импорта
 * @package backend\modules\import
 */
class ImportModel
{
    const STATUS_NEW = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_PROCESSED = 2;
    const STATUS_PROCESSED_ERROR = 3;
    const STATUS_PROCESSED_WARNING = 4;

    /** @var array Данные от json импорта */
    protected $_data = array();
    /** @var array Данные по интеграции */
    protected $_info = array();
    /** @var array Ошибки */
    protected $_error = array();
    /** @var Модель */
    private $_model;
    /** @var array Классы всех модулей импортов (загрузка из конфига) */
    private $_class = array();
    /** @var int Идентификатор текущего (ID) импорта */
    public $_import_id = 0;
    /** @var int Статус текущего импорта */
    public $_import_status = 0;

    /**
     * Загружаем в конструкторе данные из конфига
     * ImportModel constructor.
     */
    function __construct() {
        $conf = $this->getConfig('import');
        if (!empty($conf) && isset($conf['classes']))
            $this->_class = $conf['classes'];
    }

    /**
     * Чтение конфига настроек
     * @return type
     */
    protected function getConfig($name)
    {
        $path = \Yii::getAlias('@backend/config/'.$name.'.php');
        if (file_exists($path)) {
            return require($path);
        } else {
            return [
                'classes' => array(
                    'ImportCategoryModel' => array(
                        'title' => 'Импорт категорий',
                        'path' => '\backend\modules\import\ImportCategoryModel',
                        'source' => 1
                    )
                )
            ];
        }
    }

    /**
     * Обычно Контекст позволяет заменить объект Стратегии во время выполнения.
     */
    public function setStrategy(ImportStrategy $strategy)
    {
        $this->_model = $strategy;
    }

    /**
     * Получить информацию об объекте
     */
    public function registration()
    {
        $str = $this->_model->init();
        if (!empty($str))
        {
            $str = $str." ... <span style='color:green'>ok</span>";
        }
        return $str;
    }

    /** Проверка модулей импорта */
    public function init()
    {
        $str = "";
        $str .= "<div>Количество: ".count($this->_class)."</div>";
        foreach ($this->_class as $class => $data)
        {
            if (class_exists($data['path']))
            {
                $str .= "- Загрузка модуля: <u>".$class."</u> ... ";
                $this->setStrategy(new $data['path']);
                $str .= $this->registration();
                $str .= "<br/>";
            }
            else {
                $str .= "<div>- Класс: <u>".$class."</u> <b>Не существует!</b> (Или путь к нему не верный)</div>";
            }
        }
        return $str;
    }

    /**
     * Получить данные о состоянии дел с импортом
     * @param array $all - Общее кол-во записей по каждому типу
     * @return array
     */
    public function analizeImport()
    {
        $mas = array();

        foreach ($this->_class as $class => $data)
        {
            if (class_exists($data['path']))
            {
                $this->setStrategy(new $data['path']);
                $type = $this->_model->getType();
                $mas[$type]['class'] = $class;
                $mas[$type]['title'] = $data['title'];

                $mas[$type]['all'] = AdminImportTmp::find()->where(['type' => $type])->count();
                $mas[$type][0] = AdminImportTmp::find()->where(['status' => 0, 'type' => $type])->count();
                $mas[$type][1] = AdminImportTmp::find()->where(['status' => 1, 'type' => $type])->count();
                $mas[$type][2] = AdminImportTmp::find()->where(['status' => 2, 'type' => $type])->count();
            }
        }
        return $mas;
    }

    /**
     * Возвращает путь к файлу импорта
     * @return type
     */
    private function getPathToFileImport()
    {
        if (isset(Yii::$app->params['dir_import']))
        {
            $row = AdminImportList::find()->orderBy('id DESC')->one();

            if ($row)
            {
                $this->_import_id = $row->id;
                $this->_import_status = $row->status;
                $file = \Yii::getAlias(Yii::$app->params['dir_import']."/".$row->id."_import.json");
                return $file;
            }
        }
        else
            $this->_error[] = "Файл конфигурации не найден или пуст!";

        return null;
    }

    /**
     * Возвращает сведения о файле импорта и загружает данные
     */
    public function getInfoFileImport()
    {
        $file = $this->getPathToFileImport();

        if (!is_readable($file))
        {
            $this->_error[] = "Файл импорта не обнаружен!";
            $this->_info['info_file_import'] = "<div style='color:red;'>Файл импорта не обнаружен</div>";
        }
        else {
            // Информация о файле
            $unix_time = filemtime($file);
            $file_date = date('d.m.Y H:i:s', $unix_time); // вывод даты и времени в формате ДД.ММ.ГГГГ ЧЧ:ММ:СС

            $str_info_file = "Путь к Файлу импорта: " . $file . "<br>";
            $str_info_file .= "Дата создания файла: " . $file_date . "<br>";
            $this->_info['info_file_import'] = $str_info_file;

            $this->loadDataImport();

            foreach ($this->_class as $class => $data) {
                if (class_exists($data['path'])) {
                    $this->setStrategy(new $data['path']);
                    $type = $this->_model->getType();
                    $field_name = $this->_model->getFieldName();
                    $this->_info[$type] = (isset($this->_data[$field_name]) && is_countable($this->_data[$field_name])) ? count($this->_data[$field_name]) : 0;
                }
            }
        }

        return $this->_info;
    }

    /**
     * Возвращает список ошибок
     * @return array
     */
    public function getErrors()
    {
        return $this->_error;
    }


    /**
     * Загрузка данных из файла
     * @param $file
     * @return string
     */
    private function getFile($file)
    {
        if (!is_readable($file))
        {
            $this->_error[] = "Файл импорта не обнаружен";
            die("Дальнейшее отображение страницы не предусмотренно без файла импорта");
        }
        // Чтение данных из файла
        return file_get_contents($file);
    }

    /**
     * Получаем данные из файла импорта (с проверкой на json-формат)
     * @return string
     */
    private function getImportFile()
    {
        // Определяем путь к файлу
        $file = $this->getPathToFileImport();
        // Чтение данных из файла
        $json = $this->getFile($file);

        if (empty($json))
            $this->_error[] = "Файл импорта json пуст";

        if(json_last_error())
            $this->_error[] = "Данные из файла не являются json форматом";

        return $json;
    }

    /**
     * Загрузка данных для импорта по конфигу
     * Заполнение $this->_data
     */
    public function loadDataImport()
    {
        // Данные из импорта
        $json = $this->getImportFile();

        $items = (!empty($json)) ? json_decode($json) : array();

        $result = array();
        foreach ($this->_class as $class => $data)
        {
            if (class_exists($data['path']))
            {
                $this->setStrategy(new $data['path']);
                $field_name = $this->_model->getFieldName();
                $type = $this->_model->getType();

                if (isset($items->$field_name))
                    $result[$type] = (array) $items->$field_name;
            }
        }
        $this->_data = $result;
    }

    /**
     * Сохранение данных импорта во временной таблице
     * Перед сохранением очищает таблицу.
     */
    public function saveDataToTmp()
    {
        // Очищаем таблицу
        AdminImportTmp::clearData();

        // Данные из импорта. Если нет, то загружаем
        if (empty($this->_data))
            $this->loadDataImport();

        foreach ($this->_data as $type => $row)
        {
            if (!AdminImportTmp::saveData($type, (array)$row))
                $this->_error[] = "Ошибка при записи во временную таблицу ветку типа: ".$type;
        }

        if (!empty($this->_error)) return false;
        return true;
    }

    /**
     * Возвращает массив данных по импорту
     * @return array
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * Возвращает массив с кол-м данных по всем таблицам импорта
     * @return array - Массив с кол-м данных по всем таблицам импорта
     */
    public function getCountDataTableImport()
    {
        $mas = array();
        foreach ($this->_class as $class => $data)
        {
            if (class_exists($data['path']))
            {
                $this->setStrategy(new $data['path']);
                $mas[$this->_model->getType()] = $this->_model->getCountDataTable();
            }
        }
        return $mas;
    }

    /**
     * Вывод ошшибок
     * @param bool $is_console - true - вывод ошибок в консоли \r\n
     */
    public function viewErrors(bool $is_console = true){
        $br = ($is_console)? "\r\n" : "<br>";
        $error = $this->getErrors();
        if (empty($error)){
            return;
        }
        foreach ($error as $err)
            echo $err.$br;
    }

    /**
     * Запуск импорта (для автомата)
     * @param string $class - Название класса импорта
     * @return type
     */
    public function fullImportRun()
    {
        if ($this->_import_id == 0) die("ID импорта не определено.");

        $import = AdminImportList::findOne($this->_import_id);
        $import->status = ImportModel::STATUS_IN_PROGRESS;
        $import->save();

        $time1 = date("m.d.y H:i:s");
        $str = $time1." Импорт данных ...";
        echo $str." \r\n";
        $info_import = [
            'error' => [],
            'warning' => [],
        ];

        foreach ($this->_class as $class => $data)
        {
            if (class_exists($data['path']))
            {
                $this->setStrategy(new $data['path']);
                $info = $this->_model->doRun();
                $info_import = array_merge($info_import, (array)$info);
            }
        }

        $time2 = date("m.d.y H:i:s");
        $str = $time2." Импорт данных Завершен!";
        echo $str." \r\n";

        // Оптимизируем массив $this->_info
        $info_import = $this->sliceInfo($info_import);

        $import->status = ImportModel::STATUS_PROCESSED;
        if (count($info_import['error']) > 0)
            $import->status = ImportModel::STATUS_PROCESSED_ERROR;
        elseif (count($info_import['warning']) > 0)
            $import->status = ImportModel::STATUS_PROCESSED_WARNING;

            $import->comment = json_encode($info_import);
        $import->save();

        echo "<pre>"; print_r($info_import); echo "</pre>";
    }

    /**
     * Удаляем лишнее из массива Info (оптимизация)
     * @param $info
     * @return mixed
     */
    private function sliceInfo($info_import)
    {
        $max_count_error = 10;
        $max_count_warning = 10;
        $count_error = count($info_import['error']);
        $count_warning = count($info_import['warning']);

        if ($count_error > $max_count_error) {
            $info_import['error'] = array_slice($info_import['error'], 0, $max_count_error);
            $info_import['error'][] = "... есть еще ".($count_error-$max_count_error)." записей.";
        }

        if ($count_warning > $max_count_warning) {
            $info_import['warning'] = array_slice($info_import['warning'], 0, $max_count_warning);
            $info_import['warning'][] = "... есть еще ".($count_warning - $max_count_warning)." записей.";
        }

        return $info_import;
    }

    /**
     * Возвращает номер импорта
     * @return int
     */
    public function getNumberImport()
    {
        return $this->_import_id;
    }

    /**
     * Возвращает статус текущего импорта
     * @return int
     */
    public function getStatusImport()
    {
        return $this->_import_status;
    }

    /**
     * Запуск исправления (отладка) импорта
     * @param string $class - Название класса импорта
     * @return type
     */
    public function importFix($class)
    {
        if (empty($class)) return;
        $conf = $this->_class[$class];
        $this->setStrategy(new $conf['path']);
        return $this->_model->toFix();
    }

    /**
     * Вывод на экран информации в старом значении и новом
     * @return void
     */
    static function showOldNew($name, $old, $new, $br)
    {
        if (empty($name)) $name = "Без названия";
        echo "name-->" . $name . $br;
        echo "old-->" . $old . $br;
        echo "new-->" . $new . $br;
        echo "___________________________________" . $br;
    }
}