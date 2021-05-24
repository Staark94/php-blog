<?php
declare(strict_types=1);
namespace App\Controller;

use Core\Database\DB;
use Core\Http\Request;
use Core\Http\Response;

class Controller {
    public $dbh;
    public $model = null;

    public function __construct() {
        $this->dbh = DB::getInstance();
        $this->model = null;
    }
}