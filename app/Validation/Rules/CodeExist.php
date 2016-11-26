<?php

namespace App\Validation\Rules;

use App\Models\User;
use Respect\Validation\Rules\AbstractRule;

class CodeExist extends AbstractRule
{
    public function validate($input)
    {
        return User::where('token', $input)->count() > 0;
    }
}