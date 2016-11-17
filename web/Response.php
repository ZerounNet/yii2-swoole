<?php

namespace zerounnet\swoole\web;

class Response extends \yii\web\Response {
	public $swoole;
	public function setSwoole($response) {
		$this->swoole = $response;
	}
	protected function sendHeaders() {
		if ($this->isSent) {
			return;
		}
		foreach ( $this->getHeaders () as $name => $values ) {
			$name = str_replace ( ' ', '-', ucwords ( str_replace ( '-', ' ', $name ) ) );
			foreach ( $values as $value ) {
				$this->swoole->header ( $name, $value );
			}
		}
		$this->swoole->status ( $this->getStatusCode () );
		$this->sendCookies ();
	}
	protected function sendCookies() {
		\Yii::$app->getSession()->close();
		$cookies = $this->getCookies ();
		if ($cookies === null) {
			return;
		}
		$request = \Yii::$app->getRequest ();
		if ($request->enableCookieValidation) {
			if ($request->cookieValidationKey == '') {
				throw new InvalidConfigException ( get_class ( $request ) . '::cookieValidationKey must be configured with a secret key.' );
			}
			$validationKey = $request->cookieValidationKey;
		}
		foreach ( $cookies as $cookie ) {
			$value = $cookie->value;
			if ($cookie->expire != 1 && isset ( $validationKey )) {
				$value = \Yii::$app->getSecurity ()->hashData ( serialize ( [ 
						$cookie->name,
						$value 
				] ), $validationKey );
			}
			$this->swoole->cookie ( $cookie->name, $value, $cookie->expire, $cookie->path, $cookie->domain, $cookie->secure, $cookie->httpOnly );
		}
	}
	protected function sendContent() {
		return $this->swoole->end ( $this->content );
	}
}