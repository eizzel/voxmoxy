<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// application components
	'components'=>array(
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		// uncomment the following to use a MySQL database
		*/
		'db'=>array(
			'connectionString' => ENV_DEV
                    // local development server connection string
                    ? 'mysql:host=192.168.56.101;dbname=jabbervox'
                    // App Engine Cloud SQL connection string
                    // explanation:
                    // yii-framework - here is a name of App Engine project
                    // db - here is the name of Cloud SQL instance
                    : 'mysql:unix_socket=/cloudsql/jabbervoxdev:jabbervox;charset=utf8',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '5c00byd00',
			'charset' => 'utf8',
			'enableParamLogging' => true,
		),
		
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CDbLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
);