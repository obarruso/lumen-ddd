<?php

namespace App\Bitres\User\Application\Exceptions;

final class UuidAlreadyUsedException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('This UUID is already in use');
    }
}