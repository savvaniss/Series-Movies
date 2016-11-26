<?php

namespace App\Controllers\Admin;

use App\Models\User;
use App\Controllers\Controller;

class UsersController extends  Controller
{
    public function index($request, $response){
        $users = new User;
        $returnUser = $users->users();
        $this->view->getEnvironment()->addGlobal('users',$returnUser);
        return $this->view->render($response, 'admin/users.twig');
    }

    public function updateUser($request, $response){
        $action = $request->getParam('UserAction');
        $selection = $request->getParam('check');
        if (!isset($selection)){
            $this->flash->addMessage('info', 'No selection were made.');
            return $response->withRedirect($this->router->pathFor('admin.users'));
        }
        if ($action == 'delete') {
            $this->auth->user()->deleteUsers($selection);
            $this->flash->addMessage('success', 'The user deleted.');
            return $response->withRedirect($this->router->pathFor('admin.users'));
        }
        if ($action == 'block') {
            $this->auth->user()->blockUsers($selection);
            $this->flash->addMessage('success', 'The user blocked.');
            return $response->withRedirect($this->router->pathFor('admin.users'));
        }
        if ($action == 'unblock') {
            $this->auth->user()->unblockUsers($selection);
            $this->flash->addMessage('success', 'The user unblocked.');
            return $response->withRedirect($this->router->pathFor('admin.users'));
        }
    }
}

