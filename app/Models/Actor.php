<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Actor extends Model
{
    protected $table='actors';
    protected $fillable = [
        'full_name',
        'born_day',
        'slug',
        'description'
    ];

    //many to many relationship with series
    public function series(){
        return $this->belongsToMany('App\Models\Series');
    }
    
    //many to many relationship with tags
    public function tags(){
        return $this->belongsToMany('App\Models\Tag');
    }
    
    //morph relatioship for images
    public function images(){
        return $this->morphMany('App\Models\Image');
    }

}