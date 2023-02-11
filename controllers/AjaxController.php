<?php

namespace backend\modules\import\controllers;

use backend\modules\import\AdminImportList;
use backend\modules\import\ImportModel;
use Yii;
use yii\web\Controller;

class AjaxController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        if (!Yii::$app->request->isAjax) {
            die("No access request. Only ajax.");
        }

        return parent::behaviors();
    }

    /**
     * Возвращает блоки импортов с данными мониторинга
     * @return void
     */
    public function actionBlockImport()
    {
        $model = new ImportModel();
        $rows = $model->analizeImport();
        echo $this->renderPartial('blocks_import', ['params'=> $rows]);

        die;
    }

    public function actionEditStatusImport($id)
    {
        if (empty($id)) return json_encode(array('status' => 'error', 'message' => 'empty id import'));
        $import = AdminImportList::findOne($id);
        if ($import)
        {
            $import->status = 0;
            if ($import->save())
                return json_encode(array('status' => 'success'));
            else
                return json_encode(array('status' => 'error', 'message' => 'Запись по импорт не сохраняется'));
        }
        return json_encode(array('status' => 'error', 'message' => 'Запись по импорту с id = '.$id." не существует!"));
    }
}