<?php


namespace App\Controllers;

use App\Models\Image;

class FileController extends Controller
{
    protected $datadir='datahouse';
    //return image from $datadir base on file name
    public function getImage($request,$response){
        //get image name
        $imageName=$request->getAttribute('routeInfo')[2]['name'];
        //decode url characters
        $imageName=urldecode($imageName);
       // var_dump($imageName);
        //find in database if exist
        $image=Image::where('filename', '=' , $imageName)->first();
        //var_dump($image);
        //
        if(__DIR__ . '/../'.$this->datadir.'/'.$image->hash === FALSE) {
            $handler = $this->notFoundHandler;
            return $handler($request, $response);
        }
        $data = file_get_contents(__DIR__ . '/../'.$this->datadir.'/'.$image->hash);
        $header="$image->content_type; charset=utf-8";
        $response->write($data);
        return $response->withHeader('Content-Type', $header);
}

}