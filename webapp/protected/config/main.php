<?php

/*
 * Special var_dump function
 */

function d($var)
{
	echo Yii::trace(CVarDumper::dumpAsString($var), 'vardump');
}

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// define path to assets
Yii::setPathOfAlias('assets', realpath(dirname(__FILE__) . '/../../assets'));

// check environment dev or production
if (strpos(getenv("SERVER_SOFTWARE"), 'Development') === 0) {
    define('ENV_DEV', true); // we are on development machine
} else {
    define('ENV_DEV', false); // we are on production server
}


// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'defaultController' => 'default',
	'name'=>'JabberVox',

	// preloading 'log' component
	'preload'=>array('log','bootstrap'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'huatest',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','*'),
		),
        'admin',
		'default',
	),

	// application components
	'components'=>array(
        'assetManager'=>array(
			// This is special Asset Manger which can work under Google App Engine
            'class'=>'application.components.CGAssetManager',
            // CHANGE THIS: Enter here your own Google Cloud Storage bucket name Google App Engine
            'basePath'=>ENV_DEV
                    ? Yii::getPathOfAlias('assets')   // basePath for development version, assets path alias was defined above
                    : 'gs://jabbervox/assets',    // basePath for production version
            // CHANGE THIS: All files on Google Cloud Storage can be accessed via the URL below,
            // note the bucket name at the end, should be the same as in basePath above
            'baseUrl'=>ENV_DEV
                    ? '/assets'                                            // baseUrl for development App Engine
                    : 'http://commondatastorage.googleapis.com/jabbervox/assets' // baseUrl for production App Engine

        ),
		
        'request'=>array(
            'baseUrl' => '/',
            'scriptUrl' => '/',
        ),
		
		'session' => array (
			'class' => 'system.web.CDbHttpSession',
			'connectionID' => 'db',
			'sessionTableName' => 'Sessions',
		),
		
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'class'=>'WebUser',
			'autoUpdateFlash'=>false,
		),
		
		'statePersister'=>array(
			'class'=>'DbStatePersister',
		),
		// uncomment the following to enable URLs in path-format

		'urlManager'=>array(
			'urlFormat'=>'path',
            'baseUrl'=>'', // added to fix URL issues under Google App Engine
			'rules'=>array(
				'<action:(search|signup|login|logout)>' => array('default/default/<action>', 'caseSensitive' => false),
				'<action:(confirm)>/code/<c:\w+>/mId/<id:\d+>' => array('default/default/<action>/code/<c>/mId/<id>', 'caseSensitive' => false),
				
				'<controller:(dashboard)>' => array('default/dashboard', 'caseSensitive' => false),
				'<controller:(dashboard)>/<action:\w+>' => array('default/dashboard/<action>', 'caseSensitive' => false),
				'<action:(view)>/<uploadId:\d+>' => array('default/dashboard/viewUpload/uploadId/<uploadId>'),
				
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',				
				
			),
		),

//		'db'=>array(
//			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
//		),
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => ENV_DEV
                    // local development server connection string
                    ? 'mysql:host=192.168.56.101;dbname=Jabbervox'
                    // App Engine Cloud SQL connection string
                    // explanation:
                    // yii-framework - here is a name of App Engine project
                    // db - here is the name of Cloud SQL instance
                    : 'mysql:unix_socket=/cloudsql/jabbervoxdev:jabbervox;dbname=Jabbervox;charset=utf8',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => ENV_DEV ? '5c00byd00' : '',
			'charset' => 'utf8',
			'enableParamLogging' => true,
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'default/default/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					//'class'=>'CFileLogRoute', // default
					'class'=>'CSyslogRoute', // log errors to syslog (supported by Google App Engine)
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				
				array(
					'class'=>'CWebLogRoute',
					'levels' => 'trace, info, error, warning',
				),
				
			),
		),
		'bootstrap' => array(
			'class' => 'ext.bootstrap.components.Bootstrap',
			//'coreCss' => false,
			'responsiveCss' => true,
			'enableCdn' => false,
			'_assetsUrl'=>'/assets/bsext', 
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'eizzel.perez@gmail.com',
		'uploadDirectory'=>ENV_DEV? '/assets/uploads' : 'gs://jabbervax/uploads',
	),
);