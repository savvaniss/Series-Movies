<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Actor extends Model
{
    protected $table='series';
    protected $fillable = [
        'name',
        'description',
        'release_day',
        'slug'
    ];

}