<?php
// remove the following line when in production mode
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/firephp/fb.php';
define('ROOT_URL', 'http://localhost/vista');
if(!defined('URL_BASE')) {
  	define('URL_BASE', ROOT_URL . '/index.php');
} // if
if(!defined('ASSETS_URL')) {
    define('ASSETS_URL', ROOT_URL . '/assets');
} // if
defined('ASSETS_PATH') or define('ASSETS_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR.'../../assets/' );
defined('CSS_PATH') or define('CSS_PATH', ASSETS_PATH.'stylesheets/');
defined('JS_PATH') or define('JS_PATH', ASSETS_PATH.'/javascript');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name' => 'Yii Skeleton Application',
	'defaultController'=>'apps/application/index',

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.components.helpers.*',
		'application.components.behaviors.*',
		'application.components.widgets.*',
		'application.components.widgets.menu.*',
		'application.extensions.*',
		'application.controllers.AdminController',
	),
	'preload'=>array('log'),
	'modules'=>array('base', 'calendar', 'document', 'company', 'apps',
		'image' => array(
			'images_folder' => dirname(__FILE__).DIRECTORY_SEPARATOR.'../../uploads/',
			'thumbnails_folder' => dirname(__FILE__).DIRECTORY_SEPARATOR.'../../thumbnails/'
		)),
	// application components
	'components'=>array(
//		'session' => array(
//			'class' => 'system.web.CDbHttpSession',
//			'connectionID' => 'db',
//		),
		'db'=>array(
			'class'=>'CDbConnection',
			'connectionString'=>'mysql:host=localhost;dbname=vista',
			'username'=>'root',
			'password'=>'',
		),
		'email'=>array(
			'class'=>'application.extensions.email.Email',
			'delivery'=>'debug',
		),
		'user'=>array(
			'class'=>'application.components.WebUser',
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginUrl'=>array('base/user/login'),
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CWebLogRoute',
					'levels'=>'trace, info, error, warning',
					'categories'=>'application.*',
				),
				array(
					'class'=>'CWebLogRoute',
					'levels'=>'trace, info, error, warning',
					'categories'=>'system.db.*',
				),
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning, watch',
					'categories'=>'system.*',
				),
			),
		),

		'urlManager'=>array(
			'urlFormat'=>'path',
//			'showScriptName' => false,
//			//'caseSensitive'=>false,
//			'rules'=>array(
//				'user/register/*'=>'user/create',
//				'user/settings/*'=>'user/update',
//			),
		),
		'CLinkPager' => array(
			'class'=>'CLinkPager',
			'cssFile'=>false,
		),
		'wireframe' => array(
			'class'=>'CWireframe'
		),
		'locale'=>array(
			'class'=> 'CLocale',
			'id'=>'fr_FR'
		)
	),
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'poppitypop@gmail.com',
	),
);