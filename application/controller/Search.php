<?php
namespace App\controller;

use Core\Template\View;

class Search extends Controller {
    public function __construct() {
        parent::__construct();

        View::name('Search Page');
    }

    public function index() {
        View::view('search');
    }
}