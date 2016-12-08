<?php

namespace App\Auth;

use App\Models\User;
use App\Models\Group;

class Auth
{
    public function attempt($email, $password)
    {
        $user = User::where('email', $email)->first();
        if (!$user){
            return false;
        }
        if ($user->verified == '0'){
                $_SESSION['errors'] = "You must first activate your account.";
            return false;
        }
        if ($user->deleted == '1'){
            $_SESSION['errors'] = "Your account has been deleted.";
            return false;
        }
        if ($user->blocked == '1'){
            $_SESSION['errors'] = "Your account is blocked.";
            return false;
        }
        if (password_verify($password, $user->password)){
            if(empty($_SESSION['user'])){
                $_SESSION['user'] = true;
            }
            $_SESSION['user'] = $user->id;
            return true;
        }
        return false;
    }

    public function check()
    {
            return isset($_SESSION['user']);
    }

    public function user()
    {
        if (isset($_SESSION['user'])) {
            return User::find($_SESSION['user']);
        }
    }

    public function logout()
    {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }
    }

    public function isAdmin(){
        $groups=new Group;
        $user=User::find($_SESSION['user']);
        $group=$groups->getGroup($user->groupid);
        if($group->permission!='admin'){
            return false;
        }
        return true;
    }
}