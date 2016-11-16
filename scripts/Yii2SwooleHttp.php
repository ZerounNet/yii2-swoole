<?php
$env = 'dev';

switch ($env) {
	case 'beta' : // beta
		define ( 'YII_DEBUG', false ); // disable debug
		define ( 'YII_ENV', 'beta' );
		define ( 'TRACE_LEVEL', 0 );
		break;
	case 'prod' : // product environment
		define ( 'YII_DEBUG', false ); // disable debug
		define ( 'YII_ENV', 'prod' );
		define ( 'TRACE_LEVEL', 0 );
		break;
	case 'dev' :
	default : // default local
		$env = 'local';
		define ( 'YII_DEBUG', true );
		define ( 'YII_ENV', 'dev' );
		define ( 'TRACE_LEVEL', 3 );
		break;
}
require realpath ( __DIR__ . '/../../../autoload.php' ); // autoload by PSR
require realpath ( __DIR__ . '/../../../yiisoft/yii2/Yii.php' ); // Yii Core
require realpath ( __DIR__ . '/../../../../common/config/bootstrap.php' ); // register namespaces

$config = yii\helpers\ArrayHelper::merge ( require realpath ( __DIR__ . '/../../../../common/config/main.php' ), require realpath ( __DIR__ . '/../../../../common/config/main-local.php' ), require realpath ( __DIR__ . '/../../../../frontend/config/main.php' ), require realpath ( __DIR__ . '/../../../../frontend/config/main-local.php' ) );


$http = new swoole_http_server ( '0.0.0.0', 9000);
$http->on ( 'request', function ($request, $response) use ($config) {
	$_GET = isset ( $request->get ) ? $request->get : [ ];
	$_POST = isset ( $request->post ) ? $request->post : [ ];
	$_FILES = isset ( $request->files ) ? $request->files : [ ];
	$_COOKIE = isset ( $request->cookie ) ? $request->cookie : [ ];
	
	$_SERVER = array_change_key_case ( $request->server, CASE_UPPER );
	foreach ( $request->header as $k => $v ) {
		$k = 'HTTP_' . strtoupper ( str_replace ( '-', '_', $k ) );
		$_SERVER [$k] = $v;
	}
	$_SERVER ['SERVER_NAME']		= $request->header['host'];
	$_SERVER ['DOCUMENT_URI']		= $request->server ['path_info'];
	$_SERVER ['DOCUMENT_ROOT']		= \yii::getAlias ( '@frontend/web' );
	$_SERVER ['SCRIPT_NAME']		= $_SERVER ['PHP_SELF'] = $request->server ['path_info'];
	$_SERVER ['SCRIPT_FILENAME']	= "{$_SERVER ['DOCUMENT_ROOT']}{$_SERVER ['SCRIPT_NAME']}";
	$_SERVER ['REQUEST_URI']		= (isset ( $request->server ['query_string'] ) && $request->server ['query_string'])
									? "{$request->server ['request_uri']}?{$request->server ['query_string']}"
									: $request->server ['request_uri'];

	$application = new \zerounnet\swoole\web\Application ( $config );
	$application->getRequest ()->setSwoole ( $request );
	$application->getResponse ()->setSwoole ( $response );
	$application->run ();
} );
$http->start ();