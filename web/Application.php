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
	
	/**
	 * Runs the application.
	 * This is the main entrance of an application.
	 *
	 * @return integer the exit status (0 means normal, non-zero values mean abnormal)
	 */
	public function run() {
		$ret = parent::run ();
		\Yii::getLogger ()->flush ();
		return $ret;
	}
}