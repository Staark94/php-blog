<?php
namespace App\model;

use Core\Http\Response;
use Core\Model;
use Core\Template\View;

class Auth extends Model {
    protected array $fillable = ['email', 'password'];
    protected string $table = "users";
    public array $errors = [];

    public function rules() : array {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8, self::RULE_MIN, 'max' => 32]]
        ];
    }

    public function create() {
        echo "Create user";
    }

    public function getData() {
        if(isset($_SESSION['user'])) {
            $sql = $this->dbh
                ->select('type, status')
                ->from($this->table)
                ->where(['id' => $_SESSION['login']['user']])
                ->results();

            return $sql[0];
        }

        return false;
    }

    public static function user(string $data = null) {
        if(isset($_SESSION['login']['user'])) {
            switch($data) {
                case 'admin':
                    return ((new Auth())->getData()->type == 1) ?? false;
                    break;
            }

            if($data == null) return true;
        } else {
            return false;
        }
    }

    public static function login(array $data = []) {
        $model = new Auth();

        $model->loadData($data);
        
        if($model->validate()) {
            $sql = $model->dbh
                ->select('email, password')
                ->from($model->table)
                ->where(['email' => $data['email']])
                ->results()[0];


            if($sql->email != $data['email']) {
                $model->addError('email', self::RULE_MATCH, [self::RULE_MATCH, 'match' => 'email']);
            }

            if(password_verify($data['password'], $sql->password)) {
                $_SESSION['login']['user'] = $sql->id;
                $_SESSION['login']['admin'] = $sql->type ?? 0;
                $_SESSION['login']['succes'] = "Welcome back {$sql->first_name} {$sql->last_name}";
                
                if($sql->status == 0) {
                    $_SESSION['login']['status'] = "Your account need to activate.";
                }

                $_SESSION['login']['expire'] = time() + 30;

                return (new Response())->redirect('/');
            } else {
                $model->addError('password', self::RULE_MATCH, [self::RULE_MATCH, 'match' => 'password']);
            }

            View::$_vars = $model->errors;
        } else {
            View::$_vars = $model->errors;
        }
    }

    public function logout() {
        var_dump($_SESSION);
        if(isset($_SESSION['login'])) {
            unset($_SESSION['login']);
            session_destroy();
            return (new Response())->redirect('/');
        }
        else {
            return (new Response())->redirect('/');
        }

        return false;
    }
}