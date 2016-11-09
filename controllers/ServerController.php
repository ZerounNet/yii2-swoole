<?php

namespace zerounnet\swoole\controllers;

class ServerController extends \yii\console\Controller {
	/**
	 *
	 * @var string listen address
	 */
	public $bindHost = '0.0.0.0';
	/**
	 *
	 * @var int socket server listen port
	 */
	public $bindSocketPort = 9501;
	/**
	 *
	 * @var int http server listen port
	 */
	public $bindHttpPort = 9500;
	public function options($actionID) {
		return [ 
				'bindHost',
				'bindSocketPort',
				'bindHttpPort' 
		];
	}
	protected function server($mode, $server) {
		switch (strtolower ( $mode )) {
			case 'restart' :
				break;
			case 'stop' :
				break;
			case 'stats' :
				break;
			case 'list' :
				break;
			case 'start' :
			default :
				break;
		}
	}
	public function actionSocket($mode = 'start') {
		$server = new \swoole_server ( $this->bindHost, $this->bindSocketPort );
		return $this->server ( $mode, $server );
	}
	public function actionHttp($mode = 'start') {
		$server = new \swoole_websocket_server ( $this->bindHost, $this->bindHttpPort );
		return $this->server ( $mode, $server );
	}
}
