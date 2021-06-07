<?php

/*
 *---------------------------------------------------------------
 * SYSTEM DIRECTORY NAME
 *---------------------------------------------------------------
 *
 */

// Path to the system directory
define('BASEPATH', dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR);

/**
 * Start default session
 * session initialize
 */
@session_start();

/**
 * Default time zone
 */
date_default_timezone_set('Europe/Bucharest');


/**
 * Loading env data
 */
$dotenv = \Dotenv\Dotenv::createImmutable(BASEPATH);
$dotenv->load();

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

if(!empty($localhost)) {
	if($_SERVER['HTTP_HOST'] != "localhost") {
		$theme_folder = app_path() . "\\themes\\" . env('APP_THEME') . DIRECTORY_SEPARATOR;
		$localhost = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/" . rtrim($theme_folder, "/\\");
	}
} else {
	if($_SERVER['HTTP_HOST'] != "localhost") {
		$theme_folder = app_path() . "\\themes\\" . env('APP_THEME') . DIRECTORY_SEPARATOR;
		$localhost = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/" . rtrim($theme_folder, "/\\");
	}
}

// Path to the system directory
define('VIEWPATH', $view_folder . DIRECTORY_SEPARATOR);
define('CORE_PATH', BASEPATH . 'core' . DIRECTORY_SEPARATOR);
define('THEMES_PATH', $view_folder . DIRECTORY_SEPARATOR . env('APP_THEME') . DIRECTORY_SEPARATOR);
define('THEME_STYLES', $localhost);
define('LANGUAGE_PATH', 'application\languages\\' . env('APP_LANG') . DIRECTORY_SEPARATOR);
define('CACHE_PATH', 'application\cache' . DIRECTORY_SEPARATOR);
define('INSTALLED', true);