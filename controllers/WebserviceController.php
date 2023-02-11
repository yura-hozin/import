<?php

namespace backend\modules\import\controllers;

use Yii;
use backend\modules\import\WebServiceModel;
use yii\web\Controller;

/**
 * Default controller for the `modules` module
 */
class WebserviceController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;
        if (!empty($request->post('to_import')))
        {
            WebServiceModel::neadImport();
        }

        $info = WebServiceModel::getInfoWebservice();
        return $this->render('index', [
            'info' => $info,
            'value' => ''
        ]);

        return $this->render('index');
    }

    public function beforeAction($action)
    {
        if ($action->id == 'index') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
}