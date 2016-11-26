<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\AdminMiddleware;

$app->get('/', 'HomeController:index')->setName('home');

$app->group('', function (){
    $this->get('/auth/signup', 'AuthController:getSignUp')->setName('auth.signup');
    $this->post('/auth/signup', 'AuthController:postSignUp');

    $this->get('/auth/signin', 'AuthController:getSignIn')->setName('auth.signin');
    $this->post('/auth/signin', 'AuthController:postSignIn');

    $this->get('/auth/verification[/{id}[/{code}]]', 'AuthController:getVerify')->setName('auth.verify');

})->add(new GuestMiddleware($container));



$app->group('', function (){
    $this->get('/auth/signout', 'AuthController:getSignOut')->setName('auth.signout');

    $this->get('/auth/password/change', 'PasswordController:getChangePassword')->setName('auth.password.change');
    $this->post('/auth/password/change', 'PasswordController:postChangePassword');
    
})->add(new AuthMiddleware($container));

$app->group('', function (){
    $this->get('/admin/users', 'UsersController:index')->setName('admin.users');
    $this->post('/admin/users', 'UsersController:updateUser')->setName('admin.users.update');

})->add(new AdminMiddleware($container));