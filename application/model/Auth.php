<?php
namespace App\model;

use Core\Model;

class Auth extends Model {
    protected array $fillable = [];
    protected string $table = "users";
    public array $errors = [];

    public function rules() : array {
        return [];
    }

    public function create() {

    }

    public function getData() {
        if(isset($_SESSION['user'])) {
            $sql = $this->dbh
                ->select('type, status')
                ->from($this->table)
                ->where(['id' => $_SESSION['user']])
                ->results();

            return $sql[0];
        }

        return false;
    }

    public static function user(string $data = null) {
        if(isset($_SESSION['user'])) {
            switch($data) {
                case 'admin':
                    return ((new Auth())->getData()->type == 1) ?? false;

                case null:
                    return ((new Auth())->getData()->type == 0) ?? false;
            }
        }
        return false;
    }

    public function login() {
        
    }

    public function logout() {
        
    }
}