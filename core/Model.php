<?php
/**
 * Model Base
 */
declare(strict_types=1);
namespace Core;

use Core\Database\DB;

abstract class Model {
    protected $dbh;
    protected array $fillable = [];
    protected string $table = "";
    protected array $errors = [];
    protected static $instance;

    const RULE_REQUIRED = 'required';
    const RULE_EMAIL = 'email';
    const RULE_MIN = 'min';
    const RULE_MAX = 'max';
    const RULE_MATCH = 'match';
    const RULE_UNIQUE = 'unique';


    public function __construct() {
        $this->dbh = DB::getInstance();
        self::$instance =& $this;
    }

    public function loadData(array $data) {
        foreach ($data as $key => $value) {
            $this->fillable[$key] = $value;
        }
    }

    public function attributes() {
        return [];
    }

    public function labels() {
        return [];
    }

    public function getLabel($attribute) {
        return $this->labels()[$attribute] ?? $attribute;
    }

    abstract public function rules() : array;

    public function addError(string $attribute, string $rule, array $params = []) {
        $message = $this->errorMessages()[$rule] ?? '';

        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }

        $this->errors[$attribute][] = $message;
    }

    public function validate() {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->fillable[$attribute];

            foreach ($rules as $rule) {
                $ruleName = $rule;

                if(!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }

                if($ruleName === self::RULE_REQUIRED && !strlen($value)) {
                    $this->addError($attribute, self::RULE_REQUIRED);
                }

                if($ruleName === self::RULE_EMAIL && filter_var($value, FILTER_VALIDATE_EMAIL) === true) {
                    $this->addError($attribute, self::RULE_EMAIL);
                }
                
                if($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addError($attribute, self::RULE_MIN, $rule);
                }
                
                if($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addError($attribute, self::RULE_MAX, $rule);
                }
                
                if($ruleName === self::RULE_MATCH && $value != $this->fillable[$rule['match']]) {
                    $this->addError($attribute, self::RULE_MATCH, $rule);
                }
            }
        }

        return empty($this->errors);
    }

    public function errorMessages()
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be valid email address',
            self::RULE_MIN => 'Min length of this field must be {min}',
            self::RULE_MAX => 'Max length of this field must be {max}',
            self::RULE_MATCH => 'This field must be the same as {match}',
            self::RULE_UNIQUE => 'Record with with this {field} already exists',
        ];
    }

    public function hasError($attribute) {
        return $this->errors[$attribute] ?? false;
    }

    public function getError($attribute) {
        $errors = $this->errors[$attribute] ?? [];
        return $errors[0] ?? '';
    }
}