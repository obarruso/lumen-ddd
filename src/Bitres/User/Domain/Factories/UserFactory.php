<?php

namespace App\Bitres\User\Domain\Factories;

use App\Bitres\Shared\Domain\Model\ValueObjects\Uuid;
use Illuminate\Support\Str;
use App\Bitres\User\Domain\Model\User;
use App\Bitres\User\Domain\Model\ValueObjects\Email;
use App\Bitres\User\Domain\Model\ValueObjects\UserName;

class UserFactory
{
  protected $model = User::class;
  
  public static function new(array $attributes = null): User
  {
    $attributes = $attributes ?: [];

    $defaults = [
      'uuid' => Str::uuid(),
      'username' => fake()->name(),
      'email' => fake()->safeEmail(),
      'is_admin' => false,
      'is_active' => true,
    ];

    $attributes = array_replace($defaults, $attributes);

    return new User(
      uuid: new Uuid($attributes['uuid']),
      username: new UserName($attributes['username']),
      email: new Email($attributes['email']),
      is_admin: $attributes['is_admin'],
      is_active: $attributes['is_active']
    );
  }
}
