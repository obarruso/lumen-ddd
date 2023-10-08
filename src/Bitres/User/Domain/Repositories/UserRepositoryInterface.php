<?php

namespace App\Bitres\User\Domain\Repositories;

use App\Bitres\User\Domain\Model\User;
use App\Bitres\User\Domain\Model\UserCollection;
use App\Bitres\User\Domain\Model\ValueObjects\Password;

interface UserRepositoryInterface
{
    public function findAll(): UserCollection;

    public function findByUuid(string $uuid): User;

    public function findByEmail(string $email): User;

    public function store(User $user, Password $password): User;

    public function update(User $user, Password $password): void;

    public function delete(string $user_id): void;

}