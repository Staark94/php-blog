<?php
declare(strict_types=1);
namespace Core\Http;

use Core\Template\View;

class Response {
    const CODE = 200;
    const MESSAGE = "Request page not found";

    public function setResponse(int $code) {
        if($code !== self::CODE) {
            http_response_code($code);
            View::view('404');
            exit;
        }
    }

    public function redirect(string $url) {
        return header("Location: " . $url);
    }

    public function route(string $url) {
        return header("Location: " . $url, true, 200);
    }
}