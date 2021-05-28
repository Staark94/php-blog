<?php
declare(strict_types=1);
namespace App;
use Core\Database\DB;

function api() {
    $dbh = DB::getInstance();

    if(is_string('api_key') && is_string('api_secret')) {

    }
}

function getPost() {

}