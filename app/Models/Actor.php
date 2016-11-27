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

    public function series(){
        return $this->belongsToMany('App\Models\Series');
    }

    public function tags(){
        return $this->belongsToMany('App\Models\Tag');
    }

}