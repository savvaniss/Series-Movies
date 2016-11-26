<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'email',
        'name',
        'password',
        'token',
        'verified',
        'groupid',
        'deleted',
        'blocked'
    ];

    public function setPassword($password){
        $this->update([
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);
    }
    public function setVerified($id, $code){
        $this->where('id', $id)->where('token', $code)->update([
            'verified' => '1',
        ]);
    }
    public function users(){
        return $this->where('deleted', 0)->orderBy('id','asc')->get();
    }

    public function deleteUsers($id){
        $select = $this->whereIn('id', $id)->get();
        foreach ($select as $value) {
            $value->update([
                'deleted' => '1',
                'email' => bin2hex(random_bytes(3)).'_'. $value->email,
            ]);
        }
    }
    public function blockUsers($id){
        $this->whereIn('id', $id)->update([
            'blocked' => '1',
        ]);
    }
    public function unblockUsers($id){
        $this->whereIn('id', $id)->update([
            'blocked' => '0',
        ]);
    }
}