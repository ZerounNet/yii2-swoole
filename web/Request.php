<?php

namespace zerounnet\swoole\web;

class Request extends \yii\web\Request {
	public $swoole;
	public function setSwoole($request) {
		parent::getRawBody ();
		$this->swoole = $request;
	}
	public function getSwoole() {
		return $this->swoole;
	}
	public function getRawBody() {
		return $this->swoole->rawContent ();
	}
}