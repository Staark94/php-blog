<?php
namespace core\Helpers;

class Lang {
    public static function lang(string $var) {
        global $app;

        $lang = $app->initLang();
        return $lang[$var];
    }
}