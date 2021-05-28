<?php
namespace App\controller;

use Core\Template\View;

class Subscribe extends Controller {
    public function __construct() {
        parent::__construct();

        View::name('Subscribe');
    }

    public function index() {
        View::view('subscribe');
    }
}