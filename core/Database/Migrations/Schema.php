<?php declare(strict_types=1);

namespace Core\Database\Migrations;

use function array_merge;
use function count;
use function implode;
use function preg_last_error;
use function preg_match;
use function restore_error_handler;
use function set_error_handler;
use function sprintf;
use Core\Database\Migrations\AbstractMigration;

abstract class Schema extends AbstractMigration {
    public static function create(string $table_name = '', $callback)
    {
        $call = $callback;
        echo "Callback: ";
        var_dump($call);
        echo "Args: ";
        var_dump($call);
    }

    public static function drop(string $table_name = '')
    {
        
    }
}