<?php

namespace App\Common\Domain;

use App\Common\Domain\Exceptions\UnauthorizedUserException;

interface QueryInterface
{
    /**
     * @throws UnauthorizedUserException
     */
    public function handle(): mixed;
}