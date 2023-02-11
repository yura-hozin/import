<?php

namespace backend\modules\import;

use Yii;

/**
 * This is the model class for table "admin_import_list".
 *
 * @property int $id
 * @property string $date_create
 * @property int $status
 * @property string|null $date_begin
 * @property string|null $date_end
 * @property string|null $comment
 */
class AdminImportList extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_PROGRESS = 1;
    const STATUS_DONE = 2;
    const STATUS_DONE_ERROR = 3;
    const STATUS_DONE_WARNING = 4;

    const statuses = [
        self::STATUS_NEW => ['title' => 'Новый', 'class_style' => 'color-bg-new'],
        self::STATUS_PROGRESS => ['title' => 'Выполняется', 'class_style' => 'color-bg-process'],
        self::STATUS_DONE => ['title' => 'Выполнен!', 'class_style' => 'color-bg-success'],
        self::STATUS_DONE_ERROR => ['title' => 'Выполнен с ошибками', 'class_style' => 'color-bg-error'],
        self::STATUS_DONE_WARNING => ['title' => 'Выполнен с предупреждениями', 'class_style' => 'color-bg-warning'],
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_import_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_create', 'date_begin', 'date_end'], 'safe'],
            [['status'], 'integer'],
            [['comment'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_create' => 'Дата создания',
            'status' => 'Статус',
            'date_begin' => 'Начало импорта',
            'date_end' => 'Завершение импорта',
            'comment' => 'Комментарий',
        ];
    }


    /**
     * Создание записи о новом импорте или обновление времени простоя
     */
    public static function addNewFileImport()
    {
        // создаем запись
        $mod = new AdminImportList();
        $mod->status = 0;
        $mod->save();
        return $mod->id;
    }

    /**
     * Установить статус импорту
     * @param $status
     */
    public function setStatus($status)
    {
        $dd = self::updateAll(
            ['status' => $status],
            ['id' => $this->id]
        );
    }

    /**
     * Возвращает true, если есть новый импорт
     * @return object/bool
     */
    static function isNewImport()
    {
        $row = self::find()->where(['status' => self::STATUS_NEW])->one();
        return ($row) ? $row : false;
    }

    /**
     * Возвращает название статуса
     * @param $status
     * @return mixed
     */
    static function getTitleStatus($status)
    {
        return (isset(self::statuses[$status])) ? self::statuses[$status] : "???";
    }

    /**
     * Возвращает все названия статусов
     * @return \string[][]
     */
    static function getStatuses()
    {
        return self::statuses;
    }
}
