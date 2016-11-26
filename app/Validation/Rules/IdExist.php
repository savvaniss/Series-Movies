<?php

namespace App\Validation\Rules;

use App\Models\User;
use Respect\Validation\Rules\AbstractRule;

class IdExist extends AbstractRule
{
    public function validate($input)
    {
        return User::where('id', $input)->count() > 0;
    }
}