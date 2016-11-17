<?php

namespace zerounnet\swoole;

class Server extends \yii\base\Component {
	protected $config;
	public function __construct(array $config) {
		$this->config = $config;
	}
	protected $server;
	public function getServer() {
		if (! $this->server) {
			$this->init ();
		}
		return $this->server;
	}
	public function init() {
		$this->server = new swoole_server ( '0.0.0.0', 9501 );
	}
	protected function handle() {
		return [ 
				'WorkerStart' 
		];
	}
	public function onWorkerStart($server, $workerID) {
	}
	public function start() {
		$server = $this->getServer ();
		foreach ( $this->handle () as $handleName ) {
			$methodName = "on{$handleName}";
			if (method_exists ( $this, $methodName )) {
				$server->on ( $handleName, [ 
						$this,
						$methodName 
				] );
			}
		}
		$server->start ();
	}
}