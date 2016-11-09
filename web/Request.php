<?php

namespace zerounnet\swoole\web;

class Request extends \yii\web\Request {
	public $swoole;
	public function setSwoole ($request) {
		$this->swoole = $request;
	}
}