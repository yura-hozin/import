<?php
/**
 * Created by PhpStorm.
 * User: Юрий&Елена
 * Date: 10.02.23
 * Time: 21:44
 */

namespace backend\modules\import\controllers;

use yii\web\Controller;

class SettingsController extends Controller{

    /**
     * Lists all AdminImportList models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', []);
    }

} 