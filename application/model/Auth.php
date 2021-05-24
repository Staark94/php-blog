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

    public static function user() {

    }

    public function login() {
        
    }

    public function logout() {
        
    }
}