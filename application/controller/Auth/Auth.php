<?php
namespace App\controller\Auth;

use App\controller\Controller;
use App\model\Auth as AuthModel;
use Core\Template\View;

class Auth extends Controller {
    public function __construct() {
        parent::__construct();

        if(!AuthModel::user()) {
            echo "Not access garanted.";
            $this->response->route('/');
            exit;
        }
    }

    public function index() {

    }

    public function login() {

    }

    public function forgot() {

    }

    public function profile() {

    }

    public function signup() {
        View::view('user_signup');
    }
}