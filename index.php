<?php
/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 */
define('ENVIRONMENT', isset($_SERVER['APP_ENV']) ? $_SERVER['APP_ENV'] : 'production');

/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 */
switch (ENVIRONMENT) {
	case 'development':
		error_reporting(-1);
		ini_set('display_errors', 1);
		break;

	case 'testing':
	case 'production':
		ini_set('display_errors', 0);
		if (version_compare(PHP_VERSION, '5.3', '>=')) {
			error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
		} else {
			error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
		}
		break;
}

/*
 *---------------------------------------------------------------
 * SYSTEM DIRECTORY NAME
 *---------------------------------------------------------------
 *
 */

// Path to the system directory
define('BASEPATH', dirname(__FILE__));

/*
 *---------------------------------------------------------------
 * APPLICATION DIRECTORY NAME
 *---------------------------------------------------------------
 *
*/
$application_folder = 'application';


$localhost = 'localhost';

/*
 *---------------------------------------------------------------
 * VIEW DIRECTORY NAME
 *---------------------------------------------------------------
 *
*/
$view_folder = '';

// Include autoload
require_once 'vendor/autoload.php';

define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

// Path to the front controller (this file) directory
define('FCPATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);

// Name of the "system" directory
define('SYSDIR', basename(BASEPATH));

if(!empty($localhost)) {
	if($_SERVER['HTTP_REFERER'] != "localhost") {
		$theme_folder = $application_folder . "\\themes\\" . env('APP_THEME') . DIRECTORY_SEPARATOR;
		$localhost = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/" . $theme_folder;
	}
} else {
	if($_SERVER['HTTP_REFERER'] != "localhost") {
		$theme_folder = $application_folder . "\\themes\\" . env('APP_THEME') . DIRECTORY_SEPARATOR;
		$localhost = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/" . $theme_folder;
	}
}

if (is_dir($application_folder)) {
	if (($_temp = realpath($application_folder)) !== FALSE) {
		$application_folder = $_temp;
	} else {
		$application_folder = strtr(
			rtrim($application_folder, '/\\'),
			'/\\',
			DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
		);
	}
} elseif (is_dir(BASEPATH . $application_folder . DIRECTORY_SEPARATOR)) {
	$application_folder = BASEPATH . strtr(
		trim($application_folder, '/\\'),
		'/\\',
		DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
	);
} else {
	header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
	echo 'Your application folder path does not appear to be set correctly. Please open the following file and correct this: ' . SELF;
	exit(3); // EXIT_CONFIG
}

define('APPPATH', $application_folder . DIRECTORY_SEPARATOR);

// The path to the "views" directory
if (!isset($view_folder[0]) && is_dir(APPPATH . 'themes' . DIRECTORY_SEPARATOR)) {
	$view_folder = APPPATH . 'themes';
} elseif (is_dir($view_folder)) {
	if (($_temp = realpath($view_folder)) !== FALSE) {
		$view_folder = $_temp;
	} else {
		$view_folder = strtr(
			rtrim($view_folder, '/\\'),
			'/\\',
			DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
		);
	}
} elseif (is_dir(APPPATH . $view_folder . DIRECTORY_SEPARATOR)) {
	$view_folder = APPPATH . strtr(
		trim($view_folder, '/\\'),
		'/\\',
		DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
	);
} else {
	header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
	echo 'Your view folder path does not appear to be set correctly. Please open the following file and correct this: ' . SELF;
	exit(3); // EXIT_CONFIG
}

// Path to the system directory
define('VIEWPATH', $view_folder . DIRECTORY_SEPARATOR);
define('CORE_PATH', 'core' . DIRECTORY_SEPARATOR);
define('THEMES_PATH',  VIEWPATH . env('APP_THEME') . DIRECTORY_SEPARATOR);
define('LANGUAGE_PATH', 'application\languages\\' . env('APP_LANG') . DIRECTORY_SEPARATOR);
define('CACHE_PATH', 'application\cache' . DIRECTORY_SEPARATOR);


/*
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------------
 *
 * And away we go...
 */
//var_dump("path: " . THEMES_PATH);
$app = new Core\Application([
    'cache' => false,
    'theme' => env('APP_THEME', true),
    'db' => (object) [
        'dns' => "mysql:host=". env('DB_HOST') .";dbname=". env('DB_NAME') .";port=" . env('DB_PORT'),
        'user' => env('DB_USER'),
        'pass' => env('DB_PASS'),
        'charset' => env('DB_CHARSET')
    ],
    'lang' => LANGUAGE_PATH
]);

$app->run();