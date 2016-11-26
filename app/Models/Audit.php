<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Audit extends Model
{

    protected $table='audits';
    protected $fillable = [
        'route',
        'method',
        'userid'
    ];


    public function addAudit($data=[]){
        $this->route=$data[0];
        $this->method=$data[1];
        $this->userid=$data[2];
        $this->save();
    }

}