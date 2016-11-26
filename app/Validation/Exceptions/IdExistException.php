<?php

namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class IdExistException extends ValidationException
{
    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Wrong user.',
        ],
    ];
}