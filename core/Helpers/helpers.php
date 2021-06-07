<?php

if(!function_exists('env')) {
    /**
     * Get .env file data
     * @return env
     */
    function env(string $name, bool $local_only = false) {
        return isset($_ENV) ? $_ENV[$name] : '';
    }
}

if(!function_exists('app')) {
    /**
     * Get .env file data
     * @return env
     */
    function app() {
        return new \Core\Application();
    }
}

if(!function_exists('app_path')) {
    /**
     * Get .env file data
     * @return env
     */
    function app_path(string $path = '') {
        return 'application' . DIRECTORY_SEPARATOR;
    }
}