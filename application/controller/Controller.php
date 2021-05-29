<?php
declare(strict_types=1);
namespace App\controller;

use Core\Database\DB;
use Core\Http\Request;
use Core\Http\Response;
use Core\Logs\Logger;
use Core\Template\View;

class Controller {
    private static $instance;

    public $dbh;
    public $model = null;
    protected $load = null;
    public Response $response;
    public Request $request;

    public function __construct() {
        self::$instance =& $this;

        View::$model = ['Auth', 'Category'];

        $this->dbh = DB::getInstance();
        $this->model = null;
        $this->response = new Response();
        $this->request = new Request();

        if(isset($_SESSION['login']) && time() >= $_SESSION['login']['expire']) {
            unset($_SESSION['login']['succes']);
            unset($_SESSION['login']['status']);
        }

        Logger::debug('Views template init.');
        Logger::debug('Controllers init.');
        Logger::debug('Controller '. get_class($this) .' init.');
    }

    public static function &get_instance()
	{
		return self::$instance;
	}

    public function model_load(string $model_name) {
        return array_push(View::$model, $model_name);
    }

    public function pageName(string $name) {
        View::name($name);
    }
}