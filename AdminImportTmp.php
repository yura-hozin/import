<?php

namespace backend\modules\import;

use Yii;

/**
 * This is the model class for table "admin_import_tmp".
 *
 * @property int $id
 * @property int $key
 * @property string $data
 * @property int|null $type
 * @property int|null $status
 * @property string|null $comment
 * @property string|null $create_date
 */
class AdminImportTmp extends \yii\db\ActiveRecord
{
    const TYPE_CATEGORIES = 0;	    // Категории
    const TYPE_BRAND = 1;           // Бренды
    const TYPE_PRODUCTS = 2;	    // Товары
    const TYPE_COMPLECT = 3;	    // Комплектация товаров

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_import_tmp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['key', 'type', 'status'], 'integer'],
            [['data'], 'required'],
            [['data', 'comment'], 'string'],
            [['create_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'data' => 'Data',
            'type' => 'Type',
            'status' => 'Status',
            'comment' => 'Comment',
            'create_date' => 'Create Date',
        ];
    }

    /**
     * Возвращает список типов хранящихся данных
     * @return type
     */
    public static function listType()
    {
        return array(
            self::TYPE_PRODUCTS => 'Товары',
            self::TYPE_CATEGORIES => 'Категории',
            self::TYPE_BRAND => 'Бренды',
            self::TYPE_COMPLECT => 'Комплектация',
        );
    }

    /**
     * Заполнение данными таблицу порционно
     * @param $type - тип: категории, товары, бренд...
     * @param $data - данные для сохранения
     * @return bool - true - все удачно
     */
    static function saveData($type, $data)
    {
        if (empty($data)) return false;

        //Соединение с базой данных
        $connection = Yii::$app->db;

        $step = 1000;   // разбиваем массив на несколько, по step шт элементов в каждом

        for ($i=0; $i < count($data); $i=$i+$step)
        {
            $len = $step;
            $arr = array_slice($data, $i, $len, true);

            $mas = [];
            foreach ($arr as $key => $val)
            {
                $mas[] = [
                    $key,
                    json_encode($val),
                    $type,
                ];
            }

            // выполняем команду вставки
            $connection->createCommand()->batchInsert(self::tableName(), ['key', 'data', 'type'], $mas)->execute();
        }
        return true;
    }

    /**
     * Очистка таблицы
     * @throws \yii\db\Exception
     */
    static function clearData(){
        Yii::$app->db->createCommand()->truncateTable(self::tableName())->execute();
    }

    /**
     * Установка статуса (2.8 тыс - 1.7 cек)
     * @param $status
     * @return void
     */
    public function setStatus($status)
    {
        $connection = Yii::$app->db;
        $connection->createCommand()->update('admin_import_tmp', ['status' => $status], 'id = '.$this->id)->execute();
    }
}
