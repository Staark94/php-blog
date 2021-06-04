<?php
declare(strict_types=1);
namespace Core\Http;

use Core\Template\View;

class Router {
    private const METHOD_GET = 'GET';
    private const METHOD_POST = 'POST';
    private const METHOD_PUT = 'PUT';
    private const METHOD_DELETE = 'DELETE';
    private const METHOD_OPTIONS = 'OPTIONS';
    private const METHOD_PATCH = 'PATCH';
    private const METHOD_ANY = 'ANY';

    private const USER_LINKS = [
        'get' => [
            'login',
            'signup',
            'register',
            'forgot',
            'profile',
            'id'
        ],

        'allow' => [
            'login',
            'signup',
            'register',
            'forgot',
        ],

        'post' => [
            'update',
            'edit',
            'delete'
        ]
    ];

    private const POSTS_LINKS = [
        'get' => [
            'show',
            'id',
            'update',
            'create',
            'edit'
        ],

        'post' => [
            'update',
            'create',
            'edit',
            'delete'
        ]
    ];

    private static $routes = [];
    private static $ajax_request = false;

    public static function get($path, $callback, $require_ajax = false) {
        self::$routes[self::METHOD_GET][$path] = $callback;
        
        /**
         * Require ajax method
         * @param ajax
         * @return json_string
         */
        if($require_ajax != false) {
            self::$ajax_request = true;
        }
    }

    public static function post($path, $callback, $require_ajax = false) {
        self::$routes[self::METHOD_POST][$path] = $callback;
        
        /**
         * Require ajax method
         * @param ajax
         * @return json_string
         */
        if($require_ajax != false) {
            self::$ajax_request = true;
        }
    }

    public static function put($path, $callback, $require_ajax = false) {
        self::$routes[self::METHOD_PUT][$path] = $callback;
                
        /**
         * Require ajax method
         * @param ajax
         * @return json_string
         */
        if($require_ajax != false) {
            self::$ajax_request = true;
        }
    }

    public static function delete($path, $callback, $require_ajax = false) {
        self::$routes[self::METHOD_DELETE][$path] = $callback;
                
        /**
         * Require ajax method
         * @param ajax
         * @return json_string
         */
        if($require_ajax != false) {
            self::$ajax_request = true;
        }
    }

    public static function options($path, $callback, $require_ajax = false) {
        self::$routes[self::METHOD_OPTIONS][$path] = $callback;
                
        /**
         * Require ajax method
         * @param ajax
         * @return json_string
         */
        if($require_ajax != false) {
            self::$ajax_request = true;
        }
    }

    public static function patch($path, $callback, $require_ajax = false) {
        self::$routes[self::METHOD_PATCH][$path] = $callback;
                
        /**
         * Require ajax method
         * @param ajax
         * @return json_string
         */
        if($require_ajax != false) {
            self::$ajax_request = true;
        }
    }

    public static function any($path, $callback, $require_ajax = false) {
        self::$routes[self::METHOD_ANY][$path] = $callback;
                
        /**
         * Require ajax method
         * @param ajax
         * @return json_string
         */
        if($require_ajax != false) {
            self::$ajax_request = true;
        }
    }

    public static function map(array $methods = [], string $url, $callback, $require_ajax = false) {
        foreach($methods as $method) {
            self::$routes[$method][$url] = $callback;
        }
                
        /**
         * Require ajax method
         * @param ajax
         * @return json_string
         */
        if($require_ajax != false) {
            self::$ajax_request = true;
        }
    }

    public static function resorce(array $methods = [], string $prefix, array $paths = [], $callback, $require_ajax = false) {

    }
    public static function group(array $methods = [], string $prefix, array $paths = [], $callback, $require_ajax = false) {
        foreach($methods as $method) {
            foreach($paths as $url) {
                switch($url) {
                    case "all":
                        foreach(self::USER_LINKS as $link => $gets) {
                            if($link == "get") {
                                asort($gets, SORT_ASC);

                                $gets = str_replace("id", "{id}", $gets);
                                foreach($gets as $item) {
                                    if($method == "GET") self::$routes[$method]["{$prefix}/{$item}"] = $callback;
                                }
                            }

                            if($link == "post") {
                                asort($gets, SORT_ASC);

                                foreach($gets as $item)
                                    if($method == "POST") self::$routes[$method]["{$prefix}/{id}/{$item}"] = $callback;
                            }

                            if($link == "allow") {
                                asort($gets, SORT_ASC);

                                foreach($gets as $item)
                                    if($method == "POST") self::$routes[$method]["{$prefix}/{$item}"] = $callback;
                            }
                        }
                        break;

                    case "":
                        if($method == "GET") self::$routes[$method]["{$prefix}/{id}"] = $callback;
                        break;

                    case 'login':
                    case 'signup':
                    case 'register':
                    case 'forgot':
                        if($method == "GET") self::$routes[$method]["{$prefix}/{$url}"] = $callback;
                        if($method == "POST") self::$routes[$method]["{$prefix}/{$url}"] = $callback;
                        break;

                    case 'update':
                    case 'edit':
                    case 'delete':
                    case 'create':
                        if($method == "GET" && $prefix == "/posts") self::$routes[$method]["{$prefix}/{id}/{$url}"] = $callback;
                        if($method == "POST") self::$routes[$method]["{$prefix}/{id}/{$url}"] = $callback;
                        break;

                    case "profile":
                        if($method == "GET") self::$routes[$method]["{$prefix}/profile"] = $callback;
                        break;
                }
            }
        }
        
        /**
         * Require ajax method
         * @param ajax
         * @return json_string
         */
        if($require_ajax != false) {
            self::$ajax_request = true;
        }
    }

    public static function dispatch() {
        /**
         * Get url and method
         */
        $url = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        /**
         * Convert to trim url of string
         */
        $patern_regx = preg_replace("/\{(.*?)\}/i", "(?P<$1>[\w+]+)", $url);
        $patern_regx = "#^". trim($url, '/') ."$#";
        preg_match($patern_regx, trim($url, '/'), $matches);

        /**
         * Conver int to string of url
         */
        $findRoute = explode('/', $matches[0]);
        $callback = self::$routes[$method][$url] ?? false;
        
        if(count($findRoute) >= 1 && $findRoute[0] === "cat") {
            $callback = self::$routes[$method]["/cat/{name}"] ?? false;
            $args = (object) [
                'name' => $findRoute[1]
            ];
        }

        /**
         * For posts route
         * @param posts
         * @return void
         */
        if(count($findRoute) >= 1 && $findRoute[0] === "posts") {
            if($findRoute[1] >= 0) {
                $callback = self::$routes[$method]["/posts/{id}"] ?? false;
                $args = (object) [
                    'id' => $findRoute[1]
                ];
            }

            if($findRoute[1] >= 0 && !empty($findRoute[2])) {
                $callback = self::$routes[$method]["/posts/{id}/{$findRoute[2]}"] ?? false;
                $args = (object) [
                    'id' => $findRoute[1]
                ];
            }
        }

        /**
         * For user route
         * @param user
         * @return void
         */
        if(count($findRoute) > 1 && $findRoute[0] === "user") {
            // var_dump($findRoute);

            if( (is_string($findRoute[1]) && $findRoute[1] >= 1) && empty($findRoute[2]) ) {
                $callback = self::$routes[$method]["/user/{id}"] ?? false;
                $args = (object) [
                    'id' => $findRoute[1]
                ];
            }

            if( ( is_string($findRoute[1]) && $findRoute[1] >= 1) && !empty($findRoute[2]) ) {
                $callback = self::$routes[$method]["/user/{id}/{$findRoute[2]}"] ?? false;
                $args = (object) [
                    'id' => $findRoute[1]
                ];
            }

            if( is_string($findRoute[1]) ) {
                $callback = self::$routes[$method]["/user/{$findRoute[1]}"] ?? false;
            }
        }

        
        if($callback == false) 
            return (new Response())->setResponse(404);

        if($matches && is_string($callback)) {
            return View::view($callback);
        }

        if($matches && is_array($callback)) {
            $controller = new $callback[0]();
            $controller->action = $callback[1]; 
            $callback[0] = $controller;
        }

        if(is_callable($callback)) {
            call_user_func($callback, [new Request(), new Response()]);
        }
        

        /*if(!empty($args)) {
            return call_user_func_array($callback, [$args, new Request(), new Response()]);
        } else {
            return call_user_func($callback, new Request(), new Response());
        }*/
    }
}