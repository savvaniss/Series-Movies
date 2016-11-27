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
        'slug'
    ];

    public function actors(){
        return $this->belongsToMany('App\Models\Actor');
    }

    public function tags(){
        return $this->belongsToMany('App\Models\Tag');
    }

}