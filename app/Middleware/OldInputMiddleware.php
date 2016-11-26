<?php

namespace App\Middleware;


class OldInputMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        if(empty($_SESSION['old'])){
            $_SESSION['old'] = true;
        }

        $this->container->view->getEnvironment()->addGlobal('old', $_SESSION['old']);
        $_SESSION['old'] = $request->getParams();


        $response = $next($request, $response);
        return $response;
    }
}