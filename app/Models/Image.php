<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Image extends Model
{
    protected $table='images';
    protected $fillable = [
        'filename',
        'hash',
        'slug',
        'size',
        'uploaded_dir',
        'commentable_id',
        'commentable_type'
    ];
    
    public function imagenable(){
       return $this->morphTo();
    }
    
    

}