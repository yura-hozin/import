<?php

namespace backend\modules\import\models;

use Yii;

/**
 * Класс для работы со списком всех импортов
 *
 * @property int $id
 * @property string $title
 * @property string $path
 * @property int|null $source
 * @property int|null $active
 * @property int|null $position
 */
class AdminImportModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_import_model';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['source','active','position'], 'integer'],
            [['title'], 'string', 'max' => 127],
            [['path'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'path' => 'Путь',
            'source' => 'Источник',
            'active' => 'Активность',
            'position' => 'Позиция в списке',
        ];
    }
}
