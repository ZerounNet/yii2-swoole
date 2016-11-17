<?php

namespace zerounnet\swoole\controllers;

class DefaultController extends \yii\web\Controller {
	public function actionIndex() {
		$session = \Yii::$app->session;
		$session->open ();
		$session ['a'] += 1;
		var_dump ( $_SESSION );
		return var_export ( \yii::getAlias ( '@webroot' ), true ) . var_export ( \yii::$app->getRequest ()->swoole->server, true );
	}
}