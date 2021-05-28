<?php
declare(strict_types=1);
namespace App\controller\Admin;

use App\controller\Controller;
use App\model\Auth;
use Core\Database\DB;

class DashBoard extends Controller {
    /**
     * Middleware auth
     */
    public function __construct() {
        parent::__construct();

        if(!Auth::user('admin')) {
            echo "Not access garanted.";
            $this->response->route('/');
            exit;
        }
    }

    public function index() {
        echo "Admin Dashboard";
    }
}