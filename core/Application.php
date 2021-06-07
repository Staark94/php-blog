<?php
declare(strict_types=1);

namespace Core;
use Core\Database\DB;
use Core\Http\Router;
use Core\Logs\Logger;
use Core\Helpers\Url as URL;

class Application {
    public function initConnection() {
        return new DB();
    }

    public function register() {
        if(INSTALLED != false) {
            $this->initConnection();
            Router::dispatch();
            Logger::debug('Application init.');
            Logger::debug('Router dispatch init.');
        } else {
            URL::install_path();
        }
    }
}