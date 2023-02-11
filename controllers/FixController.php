<?php

namespace backend\modules\import\controllers;

use backend\modules\import\ImportModel;
use Yii;
use yii\base\ErrorException;
use yii\web\Controller;

class FixController extends Controller
{

    public function actionIndex($class)
    {
        $error = array();
        $model = new ImportModel();
        $info = array();

        if (empty($class)) return;
        try {
            $info = $model->importFix($class);
        }
        catch (ErrorException $e)
        {
            $error[] = $e->getMessage();
        }

        return $this->render('index',
            [
                'info' => $info,
                'error' => $error
            ]
        );
    }

}