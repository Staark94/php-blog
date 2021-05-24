<?php

use App\Controller\HomeController;
use App\model\User;
use Core\Database\DB;
use Core\Http\Router;
use Core\Template\View;


Router::get('/', [HomeController::class, 'index'], true);

Router::get('/cat/{name}', function() {
    //
});

Router::get('/subscribe', function() {
    //
});

Router::get('/search', function() {
    //
});

/**
 * @param all
 * @var login
 * @var signup
 * @var register
 * @var forgot
 * @var profile
 * @var id
 * @var profile
 * @var id/edit
 * @var id/update
 * @var id/delete
 */
Router::group(['GET', 'POST'], '/user', ['all'], function() {
    // 
});


/**
 * @param all
 * @var id
 * @var show
 * @var id/create
 * @var id/edit
 * @var id/update
 * @var id/delete
 */
Router::group(['GET', 'POST'], '/posts', ['', 'create', 'edit', 'update', 'delete'], function() {
    // 
});