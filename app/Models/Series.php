<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Series extends Model
{
    protected $table='series';
    protected $fillable = [
        'name',
        'description',
        'release_day',
        'slug',
        'commentable_id',
        
    ];
    
    //many to many relationship with actors
    public function actors(){
        return $this->belongsToMany('App\Models\Actor');
    }
    //many to many relationship with tags
    public function tags(){
        return $this->belongsToMany('App\Models\Tag');
    }
    //morph relatioship for images
    public function images(){
        return $this->morphMany('App\Models\Image', 'imagenable');
    }

}