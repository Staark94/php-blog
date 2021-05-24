<?php
namespace App\model;

use Core\Model;

class Posts extends Model {
    protected string $table = "posts";
    public function rules() : array { 
        return []; 
    }

    public function getPosts() {
        return $this->dbh
            ->select('*')
            ->from($this->table)
            ->results();
    }

    public function user(int $id) {
        $find_user = $this->dbh
        ->select('first_name, last_name')
        ->from('users')
        ->where(['id' => $id])
        ->results();

        
        return "{$find_user[0]->first_name}";
    }

    public function category(int $id) {
        $cat = $this->dbh
        ->select('name')
        ->from('category')
        ->where(['id' => $id])
        ->results();

        return "{$cat[0]->name}";
    }

    public function contents(string $content) {
        return htmlspecialchars_decode($content, ENT_COMPAT);
    }
}