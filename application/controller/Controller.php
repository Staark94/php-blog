<?php
declare(strict_types=1);
namespace App\controller;

use Core\Database\DB;
use Core\Http\Request;
use Core\Http\Response;
use Core\Loader\S_Loader;
use Core\Template\View;

class Controller {
    private static $instance;

    public $dbh;
    public $model = null;
    protected $load = null;
    public Response $response;

    public function __construct() {
        self::$instance =& $this;

        View::$model = ['Auth', 'Category'];

        $this->dbh = DB::getInstance();
        $this->model = null;
        $this->response = new Response();
        //$this->load = new S_Loader();
        //$this->load->initialize();
    }

    public static function &get_instance()
	{
		return self::$instance;
	}

    public function model_load(string $model_name) {
        return array_push(View::$model, $model_name);
    }

    public function pageName(string $name) {
        return View::name($name);
    }
}