<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\AdminMiddleware;

//for all users
$app->get('/', 'HomeController:index')->setName('home');
$app->get('/image/{name}', 'FileController:getImage')->setName('image');

//for guest, no logins users
$app->group('', function (){
    $this->get('/auth/signup', 'AuthController:getSignUp')->setName('auth.signup');
    $this->post('/auth/signup', 'AuthController:postSignUp');
    $this->get('/auth/signin', 'AuthController:getSignIn')->setName('auth.signin');
    $this->post('/auth/signin', 'AuthController:postSignIn');
    $this->get('/auth/verification[/{id}[/{code}]]', 'AuthController:getVerify')->setName('auth.verify');
})->add(new GuestMiddleware($container));

//for authenticated users
$app->group('', function (){
    $this->get('/auth/signout', 'AuthController:getSignOut')->setName('auth.signout');
    $this->get('/auth/password/change', 'PasswordController:getChangePassword')->setName('auth.password.change');
    $this->post('/auth/password/change', 'PasswordController:postChangePassword');
    $this->get('/series/show',  'SeriesController:getShowSeries')->setName('series.show');
    $this->get('/series/show/single/{slug}', 'SeriesController:singleSeries')->setName('series.single');
})->add(new AuthMiddleware($container));

//for admin users
$app->group('', function (){
    $this->get('/admin/users', 'UsersController:index')->setName('admin.users');
    $this->post('/admin/users', 'UsersController:updateUser')->setName('admin.users.update');
    $this->get('/series/create', 'SeriesController:getCreateSeries')->setName('series.create');
    $this->post('/series/create', 'SeriesController:postCreateSeries');
})->add(new AdminMiddleware($container));