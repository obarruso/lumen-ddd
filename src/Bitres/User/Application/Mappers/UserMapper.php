<?php

namespace App\Bitres\User\Application\Mappers;

use App\Bitres\Shared\Domain\Model\ValueObjects\Uuid;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Bitres\User\Domain\Model\User;
use App\Bitres\User\Domain\Model\ValueObjects\Email;
use App\Bitres\User\Domain\Model\ValueObjects\UserName;
use App\Bitres\User\Infrastructure\EloquentModels\UserEloquentModel;

class UserMapper
{
    public static function fromRequest(Request $request, ?string $uuid): User
    {
        return new User(
            uuid: new Uuid($uuid),
            username: new UserName($request->string('username')),
            email: new Email($request->string('email')),
            is_admin: $request->boolean('is_admin', false),
            is_active: $request->boolean('is_active', true),
        );
    }

    public static function fromEloquent(UserEloquentModel $userEloquent): User
    {
        return new User(
            uuid: new Uuid($userEloquent->uuid),
            username: new UserName($userEloquent->username),
            email: new Email($userEloquent->email),
            is_admin: $userEloquent->is_admin,
            is_active: $userEloquent->is_active
        );
    }

    public static function fromAuth(Authenticatable $userEloquent): User
    {
        return new User(
            uuid: new Uuid($userEloquent->uuid),
            username: new UserName($userEloquent->name),
            email: new Email($userEloquent->email),
            is_admin: $userEloquent->is_admin,
            is_active: $userEloquent->is_active
        );
    }

    public static function toEloquent(User $user): UserEloquentModel
    {
        $userEloquent = new UserEloquentModel();
        $userEloquent->uuid = $user->uuid;
        $userEloquent->username = $user->username;
        $userEloquent->email = $user->email;
        $userEloquent->is_admin = $user->is_admin;
        $userEloquent->is_active = $user->is_active;
        return $userEloquent;
    }
}