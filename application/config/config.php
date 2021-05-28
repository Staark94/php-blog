<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Core\Template\View;
/**
 * Loading env data
 */
$dotenv = Dotenv\Dotenv::createImmutable(BASEPATH);
$dotenv->load();

/**
 * Get .env file data
 * @return env
 */
function env(string $name, bool $local_only = false) {
    return isset($_ENV) ? $_ENV[$name] : '';
}

/**
 * Start default session
 * session initialize
 */
session_start();

/**
 * Default time zone
 */
date_default_timezone_set('Europe/Bucharest');

$config['base_url'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$config['base_url'] .= "://".$_SERVER['HTTP_HOST'];
$config['base_url'] .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);

$config['index_page'] = '';

$config['uri_protocol']	= 'REQUEST_URI';

$config['url_suffix'] = '';

$config['language']	= 'english';

$config['charset'] = 'UTF-8';

$config['log_date_format'] = 'Y-m-d H:i:s';

/*
|--------------------------------------------------------------------------
| Cookie Related Variables
|--------------------------------------------------------------------------
*/
$config['cookie_prefix']	= '';
$config['cookie_domain']	= '';
$config['cookie_path']		= '/';
$config['cookie_secure']	= FALSE;
$config['cookie_httponly'] 	= FALSE;

/*
|--------------------------------------------------------------------------
| Cross Site Request Forgery
|--------------------------------------------------------------------------
*/
$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();