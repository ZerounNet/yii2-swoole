<?php

namespace yii2swoole\controllers;

use yii\web\Controller;

/**
 * Default controller for the `yii2swoole` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
