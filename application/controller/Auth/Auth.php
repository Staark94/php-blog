<?php
namespace App\controller\Auth;

use App\controller\Controller;
use App\model\Auth as AuthModel;
use Core\Http\Request;
use Core\Http\Response;
use Core\Template\View;

class Auth extends Controller {
    public function __construct() {
        parent::__construct();

        $this->model = new AuthModel();
    }

    public function login() {
        $this->pageName('Sign Up');

        if(isset($_SESSION['login'])) {
            $this->response->redirect('/');
        }

        if($this->request->isPost()) {
            $data = $this->request->getBody();
            AuthModel::login($data);
        }

        View::view('user_signup');
    }

    public function forgot() {
        $this->pageName('Forgot Password');
    }

    public function logout() {
        return $this->model->logout();
    }

    public function profile() {
        $this->pageName('User Profile');
        View::view('profile');
    }

    public function signup() {
        $this->pageName('Sign Up');

        if(isset($_SESSION['login'])) {
            $this->response->redirect('/');
        }

        if($this->request->isPost()) {
            $data = $this->request->getBody();
            AuthModel::login($data);
        }

        View::view('user_signup');
    }
}