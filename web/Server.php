<?php

namespace zerounnet\swoole\web;

class Server extends \zerounnet\swoole\Server {
	public function init() {
		$this->server = new \Swoole\Http\Server ( '0.0.0.0', 9000 );
	}
	protected function handle() {
		return \yii\helpers\ArrayHelper::merge ( parent::handle (), [ 
				'Request' 
		] );
	}
	public function onRequest($request, $response) {
		$_GET = isset ( $request->get ) ? $request->get : [ ];
		$_POST = isset ( $request->post ) ? $request->post : [ ];
		$_FILES = isset ( $request->files ) ? $request->files : [ ];
		$_COOKIE = isset ( $request->cookie ) ? $request->cookie : [ ];
		
		$_SERVER = array_change_key_case ( $request->server, CASE_UPPER );
		foreach ( $request->header as $k => $v ) {
			$k = 'HTTP_' . strtoupper ( str_replace ( '-', '_', $k ) );
			$_SERVER [$k] = $v;
		}
		$_SERVER ['SERVER_NAME'] = $request->header ['host'];
		$_SERVER ['DOCUMENT_ROOT'] = \Yii::getAlias ( '@frontend/web' );
		$_SERVER ['DOCUMENT_URI'] = '/index.php';
		$_SERVER ['PHP_SELF'] = '/index.php';
		$_SERVER ['SCRIPT_NAME'] = '/index.php';
		$_SERVER ['SCRIPT_FILENAME'] = "{$_SERVER ['DOCUMENT_ROOT']}{$_SERVER ['SCRIPT_NAME']}";
		$_SERVER ['REQUEST_URI'] = (isset ( $request->server ['query_string'] ) && $request->server ['query_string']) ? "{$request->server ['request_uri']}?{$request->server ['query_string']}" : $request->server ['request_uri'];
		
		\yii\base\Event::offALl ();
		\yii\base\Widget::$counter = 0;
		\yii\base\Widget::$stack = [ ];
		
		$application = new \zerounnet\swoole\web\Application ( $this->config );
		$application->getRequest ()->setSwoole ( $request );
		$application->getResponse ()->setSwoole ( $response );
		$application->run ();
	}
}