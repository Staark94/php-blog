<?php
namespace App\model;

use Core\Model;

class Test extends Model {
   protected array $fillable = [];
   protected string $table = '';
   public array $errors = [];


   public function rules() : array {
       return [];
   }
}