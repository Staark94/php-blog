<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = array();

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


/*
|--------------------------------------------------------------------------
| Cache Related Variables
|--------------------------------------------------------------------------
*/
$config['cache_file'] = '';
$config['cache_prefix'] = '';
$config['cache_store'] = false;
$config['cache_db'] = false;

/*
|--------------------------------------------------------------------------
| Theme Related Variables Configuration
|--------------------------------------------------------------------------
*/
$config['theme']['style'] = 'bootstrap';
$config['theme']['path'] = 'themes';
$config['theme']['layout'] = 'main';
$config['theme']['parts'] = 'parts';

/*
|--------------------------------------------------------------------------
| Language Related Variables Configuration
|--------------------------------------------------------------------------
*/
$config['lang'] = 'english';