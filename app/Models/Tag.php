<?php
/**
 * Created by PhpStorm.
 * User: savva
 * Date: 11/27/2016
 * Time: 2:56 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table='tags';
    protected $fillable = [
        'value',
        'slug'
    ];

    public function actors(){
        return $this->belongsToMany('App\Models\Actor');
    }

    public function series(){
        return $this->belongsToMany('App\Models\Series');
    }

}