<?php declare(strict_types=1);

namespace Core\Database\Migrations;

use Closure;

class Blueprint {
    public function __construct(string $table, Closure $callback = null, string $prefix = '') {
        $this->$table = $table;
        $this->callback = $callback;
        $this->prefix = $prefix;
    }

    public static function __callStatic(string $method, array $parameters) {
        echo "Calling static method '$method' "
        . implode(', ', $parameters). "\n";
    }

    public function __call(string $method, array $parameters) {
        echo "Calling object method '$method' "
        . implode(', ', $parameters). "\n";
    }

    public function id() {
        return "id";
    }

    public function string(string $column, int $length = null) {
        return $column;
    }
}
