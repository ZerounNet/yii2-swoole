<?php
namespace zerounnet\swoole\controllers;

class DefaultController extends \yii\web\Controller {
	public function actionIndex () {
		return var_export(\yii::getAlias('@web'), true).var_export($_SERVER, true);
	}
}