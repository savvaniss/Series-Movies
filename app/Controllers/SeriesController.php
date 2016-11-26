<?php

namespace App\Controllers;

use App\Models\User;
use Slim\Views\Twig as View;
use Respect\Validation\Validator as v;

class SeriesController extends Controller
{
    public function getCreateSeries($request,$response)
    {
        return $this->container->view->render($response, 'series.create.twig');
    }

    public function postCreateSeries($request,$response){

        $validation = $this->validator->validate($request, [
            // ->emailAvailable()
            'title' => v::notEmpty(),
            'content' => v::notEmpty()
        ]);
        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('series.create'));
        }

    }
}