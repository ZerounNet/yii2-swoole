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

foreach ( \Yii::$classMap as $className => $includeFile ) {
	if (! in_array ( $includeFile, get_included_files () )) {
		\Yii::autoload ( $className );
	}
}
$config = yii\helpers\ArrayHelper::merge ( require realpath ( __DIR__ . '/../../../../common/config/main.php' ), require realpath ( __DIR__ . '/../../../../common/config/main-local.php' ), require realpath ( __DIR__ . '/../../../../frontend/config/main.php' ), require realpath ( __DIR__ . '/../../../../frontend/config/main-local.php' ) );

$server = new \zerounnet\swoole\web\Server ( $config );
$server->start ();