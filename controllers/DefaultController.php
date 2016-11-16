<?php
namespace zerounnet\swoole\controllers;

class DefaultController extends \yii\web\Controller {
	public function actionIndex () {
		return var_export(\yii::getAlias('@webroot'), true).var_export(\yii::$app->getRequest()->swoole->server, true);
	}
}