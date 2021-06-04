<?php
namespace App\model;

use Core\Model;

class Category extends Model {
    protected $table = "category";
    
    public function rules() : array { 
        return []; 
    }

    public function get() {
        return $this->dbh
            ->select('*')
            ->from($this->table)
            ->results();
    }
}