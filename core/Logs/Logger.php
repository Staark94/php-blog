<?php
declare(strict_types=1);

namespace Core\Logs;

class Logger {
    public static $path = "";

    public static function debug(string $msg) {
        self::$path = APPPATH . "logs" . DIRECTORY_SEPARATOR;

        if(is_dir(self::$path)) {
            if(file_exists(self::$path)) {
                $fh = fopen(self::$path . "debug.log", 'a');
                fwrite($fh, "(". Date('Y-m-d h:m:i') .") [DEBUG]: " . trim($msg, "\n") . PHP_EOL, 2000);
                fclose($fh);
            }
        }
    }

    public static function log(string $msg) {
        self::$path = APPPATH . "logs" . DIRECTORY_SEPARATOR;

        if(is_dir(self::$path)) {
            if(file_exists(self::$path)) {
                $fh = fopen(self::$path . "errors.log", 'ax+');
                fwrite($fh, "(". Date('Y-m-d h:m:i') .") [DEBUG]: " . $msg . "\n");
                fclose($fh);
            }
        }
    }
}