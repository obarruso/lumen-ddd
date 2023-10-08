<?php

namespace App\Bitres\User\Application\Repositories\Eloquent;

use App\Bitres\User\Application\Mappers\UserMapper;
use App\Bitres\User\Domain\Model\User;
use App\Bitres\User\Domain\Model\UserCollection;
use App\Bitres\User\Domain\Model\ValueObjects\Password;
use App\Bitres\User\Domain\Repositories\UserRepositoryInterface;
use App\Bitres\User\Infrastructure\EloquentModels\UserEloquentModel;

class UserRepository implements UserRepositoryInterface
{
    public function findAll(): UserCollection
    {
        $users = UserCollection::createEmpty();
        foreach (UserEloquentModel::all() as $userEloquent) {
            $users->add(UserMapper::fromEloquent($userEloquent));
        }
        return $users;
    }

    public function findByUuid(string $uuid): User
    {
        $userEloquent = UserEloquentModel::query()->where('uuid', $uuid)->firstOrFail();
        // ->findOrFail($uuid);
        return UserMapper::fromEloquent($userEloquent);
    }

    public function findByEmail(string $email): User
    {
        $userEloquent = UserEloquentModel::query()->where('email', $email)->firstOrFail();
        return UserMapper::fromEloquent($userEloquent);
    }

    public function store(User $user, Password $password): User
    {
        $userEloquent = UserMapper::toEloquent($user);
        $userEloquent->password = $password->value;
        $userEloquent->save();

        return UserMapper::fromEloquent($userEloquent);
    }

    public function update(User $user, Password $password): void
    {
        $userEloquent = UserMapper::toEloquent($user);
        if ($password->isNotEmpty()) {
            $userEloquent->password = $password->value;
        }
        $userEloquent->update();
    }

    public function delete(string $user_id): void
    {
        // TODO: Convert in softdelete
        $userEloquent = UserEloquentModel::query()->findOrFail($user_id);
        $userEloquent->delete();
    }
}