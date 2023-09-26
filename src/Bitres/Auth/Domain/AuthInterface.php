<?php

namespace App\Bitres\Auth\Domain;

use App\Bitres\User\Domain\Model\User;
use Illuminate\Auth\AuthenticationException;

interface AuthInterface
{
    /**
     * @throws AuthenticationException
     */
    public function login(array $credentials): string;

    /**
     * @throws AuthenticationException
     */
    public function refresh(): string;

    public function logout(): void;
    public function me(): User;
}