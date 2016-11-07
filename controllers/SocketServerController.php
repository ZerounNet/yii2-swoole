<?php

namespace zerounnet\swoole\controllers;

use yii\console\Controller;

class SocketServerController extends Controller {
	public $message;
	public function options() {
		return [ 
				'message' 
		];
	}
	public function optionAliases() {
		return [ 
				'm' => 'message' 
		];
	}
	public function actionIndex() {
		echo $this->message . "\n";
	}
}