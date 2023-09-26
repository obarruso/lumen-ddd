<?php

namespace App\Bitres\User\Domain\Repositories;

use App\Bitres\User\Domain\Model\User;
use App\Bitres\User\Domain\Model\ValueObjects\Password;

interface UserRepositoryInterface
{
    public function findAll(): array;

    public function findByUuid(string $uuid): User;

    public function findByEmail(string $email): User;

    public function store(User $user, Password $password): User;

    public function update(User $user, Password $password): void;

    public function delete(int $user_id): void;

}