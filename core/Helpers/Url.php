<?php
namespace core\Helpers;

class Url {
    public static function site_url()
    {
        return '/';
    }

    public static function url_to(string $url) {
        return strtolower($url);
    }

    public static function url_from(string $path, array $param = []) {
        return "{$path}/{$param[0]}";
    }

    public static function install_path() {
        header("Location: app.php?install&steep=1");
        return true;
    }
}