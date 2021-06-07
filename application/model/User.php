<?php
namespace App\model;

use Core\Model;
use Core\Database\DB;

class User extends Model {
    protected $fillable = ['first_name', 'last_name', 'email', 'password', 'passwordConfirm', 'mobile'];
    protected $table = "users";
    public $errors = [];
    public static $instance;

    public function __construct() {
        self::$instance = $this;
    }

    public function rules() : array {
        return [
            'first_name' => [self::RULE_REQUIRED],
            'last_name' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [
                self::RULE_UNIQUE, 'class' => User::class
            ]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8, self::RULE_MIN, 'max' => 32]],
            'passwordConfirm' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']]
        ];
    }

    public function getName() {

    }

    public function acces() {

    }

    public static function created($params = []) {
        return DB::getInstance()->insert('users', $params);
    }
}