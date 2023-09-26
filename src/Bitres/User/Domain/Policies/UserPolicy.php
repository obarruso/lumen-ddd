<?php

namespace App\Bitres\User\Domain\Policies;

use App\Bitres\User\Domain\Model\User;

class UserPolicy
{
    public static function findAll(): bool
    {
        return auth()->user()?->is_admin ?? false;
    }

    public static function findByUuid(): bool
    {
        return auth()->user()?->is_admin ?? false;
    }

    public static function findByEmail(): bool
    {
        return auth()->user()?->is_admin ?? false;
    }

    public static function store(): bool
    {
        return auth()->user()?->is_admin ?? false;
    }

    public static function update(User $user): bool
    {
        return auth()->user()?->is_admin || auth()->user()?->uuid == $user->uuid;
    }

    public static function delete(): bool
    {
        return auth()->user()?->is_admin ?? false;
    }

    public static function getRandomAvatar(): bool
    {
        return true;
    }

}