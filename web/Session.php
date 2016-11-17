<?php

namespace zerounnet\swoole\web;

class Session extends \yii\web\Session {
	public function close() {
		if ($this->getIsActive () && $this->getUseCookies () === true && $this->getHasSessionId () === false) {
			$data = $this->getCookieParams ();
			extract ( $data );
			if (isset ( $lifetime, $path, $domain, $secure, $httponly )) {
				$cookies = \Yii::$app->getResponse ()->cookies;
				$cookies->add ( new \yii\web\Cookie ( [ 
						'name' => $this->getName (),
						'value' => $this->getId (),
						'domain' => $domain,
						'path' => $path,
						'expire' => time () + $lifetime,
						'secure' => $secure,
						'httpOnly' => $httponly 
				] ) );
			} else {
				$cookies = \Yii::$app->getResponse ()->cookies;
				$cookies->add ( new \yii\web\Cookie ( [ 
						'name' => $this->getName (),
						'value' => $this->getId () 
				] ) );
			}
		}
		parent::close ();
	}
}