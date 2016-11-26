<?php

namespace App\Controllers;

use App\Models\User;
use Slim\Views\Twig as View;
class SeriesController extends Controller
{
    public function createSeries($request,$response)
    {
        return $this->container->view->render($response, 'series.create.twig');
    }
}