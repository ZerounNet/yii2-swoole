<?php

namespace zerounnet\swoole\web;

class Application extends \yii\web\Application {
	/**
	 * @inheritdoc
	 */
	public function coreComponents() {
		return array_merge ( parent::coreComponents (), [ 
				'request' => [ 
						'class' => \zerounnet\swoole\web\Request::className () 
				],
				'response' => [ 
						'class' => \zerounnet\swoole\web\Response::className () 
				],
				'session' => [ 
						'class' => \zerounnet\swoole\web\Session::className () 
				] 
		] );
	}
}