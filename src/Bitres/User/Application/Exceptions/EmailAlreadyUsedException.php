<?php

namespace App\Bitres\User\Application\Exceptions;

final class EmailAlreadyUsedException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('This email is already in use');
    }
}