<?php

namespace App\Middleware;
use App\Models\Group;


class AdminMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        if (!$this->container->auth->check()){
            $this->container->flash->addMessage('error', 'Please sign in before doing that.');
            return $response->withRedirect($this->container->router->pathFor('auth.signin'));
        }

        if(!$this->container->auth->isAdmin()){

            $this->container->flash->addMessage('error', 'You are not Authorized to view this page');
            return $response->withRedirect($this->container->router->pathFor('home'));
        }


        $response = $next($request, $response);
        return $response;
    }
}