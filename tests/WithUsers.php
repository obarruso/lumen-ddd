<?php

namespace Tests;

use App\Bitres\User\Application\Mappers\UserMapper;
use App\Bitres\User\Domain\Factories\UserFactory;
use App\Bitres\User\Domain\Model\User;
use Tests\Illuminate\Foundation\Testing\WithFaker;

trait WithUsers
{
  use WithFaker;

    protected function newUser(): User
    {
        $user = UserFactory::new();
        $userEloquent = UserMapper::toEloquent($user);
        $userEloquent->password = $this->faker->password(8);
        $userEloquent->save();
        return UserMapper::fromEloquent($userEloquent, app()->make(AvatarRepositoryInterface::class));
    }

    protected function createRandomUsers($usersNumber = 1): array
    {
        $user_ids = [];
        foreach (range(1, $usersNumber) as $_) {
            $user = UserFactory::new();
            $userEloquent = UserMapper::toEloquent($user);
            $userEloquent->password = $this->faker->password(8);
            $userEloquent->save();

            $user_ids[] = $userEloquent->id;
        }
        return $user_ids;
    }
}