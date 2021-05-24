<?php
/**
 * 
 * 
 */
require_once 'vendor/autoload.php';

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