<?php

namespace App\Controllers;

use App\Models\Actor;
use App\Models\Series;
use App\Models\Tag;
use Slim\Views\Twig as View;
use Respect\Validation\Validator as v;
use Cocur\Slugify\Slugify as slug;
use Carbon\Carbon as carbon;

class SeriesController extends Controller
{
    protected $datadir='datahouse';
    public function getCreateSeries($request,$response)
    {
        return $this->container->view->render($response, 'series.create.twig');
    }

    public function postCreateSeries($request,$response){

//        $image=$request->getUploadedFiles();
//        var_dump($image);
//        echo "error";
//        var_dump($image['input-file-preview']->getError());
//        echo "mediatype";
//        var_dump($image['input-file-preview']->getClientMediaType());
//        echo "filename";
//        var_dump($image['input-file-preview']->getClientFilename());
//        echo "size";
//        var_dump($image['input-file-preview']->getSize());
//        echo "stream";
//        var_dump($image['input-file-preview']->getStream());
//        //moveTo();
//        die();

        //validate input
        $validation = $this->validator->validate($request, [
            // ->emailAvailable()
            'name' => v::notEmpty(),
            'description' => v::notEmpty(),
            'actor' => v::notEmpty(),
            'release_day'=>v::date()
        ]);
        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('series.create'));
        }
        //use slug class to sluglify series name
        $slug=new Slug;
        $date = Carbon::parse($request->getParam('release_day'));
        $sluglified=$slug->slugify($request->getParam('name'));

        //insert series to database
        $series=Series::create([
            'name' => $request->getParam('name'),
            'description' => $request->getParam('description'),
            'release_day' => $date,
            'slug' => $sluglified
        ]);

        //explode tags in array split by comma
        $tags=explode(',',$request->getParam('tag'));
        foreach($tags as $tag){
            //create new tag in database
            $createdTag[$tag]=Tag::create([
                'value' => $tag,
                'slug' => $slug->slugify($tag)
            ]);
            //define tag with many to many relationship
            $series->tags()->attach($createdTag[$tag]);

        }

        //explode actors
        $actors=explode(',',$request->getParam('actor'));
        foreach($actors as $actor){
            //create new tag in database
            $createdActor[$actor]=Actor::create([
                'full_name' => $actor,
                'slug' => $slug->slugify($actor)
            ]);
            //define tag with many to many relationship
            $series->actors()->attach($createdActor[$actor]);

        }
        
        $this->flash->addMessage('success', 'Your Series created!');
        return $response->withRedirect($this->router->pathFor('series.show'));

    }

        public function getShowSeries($request, $response){
            return $this->container->view->render($response, 'series.show.twig');
        }
}