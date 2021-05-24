<?php
declare(strict_types=1);

/**
 * Start default session
 * session initialize
 */
session_start();

/**
 * Error reporting
 */
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
date_default_timezone_set('Europe/Bucharest');

/**
 * Loading env data
 */
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

/**
 * Get .env file data
 * @return env
 */
function env(string $name, bool $local_only = false) {
    return isset($_ENV) ? $_ENV[$name] : '';
}

/**
 * Define php path routes string
 */

define('ROOT_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('APP_PATH', 'application' . DIRECTORY_SEPARATOR);
define('CORE_PATH', 'core' . DIRECTORY_SEPARATOR);
define('THEMES_PATH', 'application\themes' . DIRECTORY_SEPARATOR . env('APP_THEME') . DIRECTORY_SEPARATOR);
define('LANGUAGE_PATH', 'application\languages\\' . env('APP_LANG') . DIRECTORY_SEPARATOR);
define('CACHE_PATH', 'application\cache' . DIRECTORY_SEPARATOR);