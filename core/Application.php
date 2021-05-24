<?php
declare(strict_types=1);

namespace Core;
use Core\Database\DB;
use Core\Http\Router;

class Application {
    public $config = [];

    public function __construct(array $default = [])
    {
        $this->config = (object) $default;

        return $this->config;
    }

    public function initConnection() {
        return new DB();
    }

    public function run() {
        $this->initConnection();
        Router::dispatch();
    }
}