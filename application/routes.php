<?php

use App\Controller\HomeController;
use App\controller\Admin\DashBoard;
use App\Controller\Subscribe;
use App\Controller\Search;
use App\controller\Auth\Auth;
use App\model\User;
use Core\Database\DB;
use Core\Http\Router;
use Core\Template\View;


Router::get('/', [HomeController::class, 'index'], true);

Router::get('/cat/{name}', function() {
    //
});

Router::get('/subscribe', [Subscribe::class, 'index']);
Router::get('/search', [Search::class, 'index']);

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
Router::get('/user/login', [Auth::class, 'login']);
Router::get('/user/signup', [Auth::class, 'signup']);
Router::get('/user/register', [Auth::class, 'signup']);
Router::get('/user/forgot', [Auth::class, 'forgot']);
Router::get('/user/profile', [Auth::class, 'profile']);
Router::get('/user/{id}', [Auth::class, 'index']);

Router::post('/user/login', [Auth::class, 'login']);
Router::post('/user/signup', [Auth::class, 'signup']);
Router::post('/user/register', [Auth::class, 'signup']);
Router::post('/user/forgot', [Auth::class, 'forgot']);

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

Router::get('/admin', [DashBoard::class, 'index']);