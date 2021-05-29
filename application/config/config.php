<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
@session_start();

/**
 * Default time zone
 */
date_default_timezone_set('Europe/Bucharest');