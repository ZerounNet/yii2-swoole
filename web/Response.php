<?php

namespace zerounnet\swoole\web;

class Response extends \yii\web\Response {
	public $swoole;
	public function setSwoole($response) {
		$this->swoole = $response;
	}
	protected function sendContent() {
		if ($this->content === null ) {
			$this->swoole->end();
		} else {
			$this->swoole->end ( $this->content );
		}
	}
}