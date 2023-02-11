<?php

namespace backend\modules\import\controllers;

use Yii;
use backend\modules\import\ImportModel;
use yii\web\Controller;

/**
 * Default controller for the `modules` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $model = new ImportModel();

        /* --- Информация по файлу импорта и загрузка данных из него --- */
        $info = $model->getInfoFileImport();

        // *----- Проверка модулей импорта --- *
        $str_info_modules_import = $model->init();
        $info['init_modules_import'] = $str_info_modules_import;

        // Проверка на ошибки
        if (count($model->getErrors()) > 0)
        {
            $err = $model->getErrors();
            foreach ($err as $error)
                Yii::$app->session->setFlash('error', $error);
        }
        else{
            // Кол-во записей во всех таблицах БД, связанных с импортом
            $count_to_tables = $model->getCountDataTableImport();

            // Загружаем данные импорта в _data
            $model->loadDataImport();

            $name_type = \backend\modules\import\AdminImportTmp::listType();
            $info['block_all_data'] = $this->renderPartial('block_all_data', ['params'=> $model->getData(), 'name_type' => $name_type]);

            $info['block_check_all_data'] = $this->renderPartial('block_check_all_data',
                [
                    'params'=> $model->getData(),
                    'count_tables' => $count_to_tables,
                ]
            );

            $info['current_number_import'] = $model->getNumberImport();
            $info['current_status_import'] = $model->getStatusImport();
        }

        return $this->render('index',[
            'info' => $info
        ]);
    }
}
