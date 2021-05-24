<?php
namespace App\model;

use Core\Model;

class User extends Model {
    protected array $fillable = ['first_name', 'last_name', 'email', 'password', 'passwordConfirm'];
    protected string $table = "users";
    public array $errors = [];


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
}