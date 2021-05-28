<?php
namespace App\controller;

use App\model\Posts;
use Core\Template\View;

class HomeController extends Controller {
    public $model;

    public function __construct() {
        parent::__construct();

        $this->model_load('Posts');
        $this->pageName('Home Page');
        $this->model = new Posts();
    }

    public function index() {
        View::view('home');
    }

    public function create() {}
    public function update() {}
    public function store() {}
    public function delete() {}
}