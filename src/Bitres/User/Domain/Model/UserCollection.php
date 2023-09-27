<?php

declare(strict_types=1);

namespace App\Bitres\User\Domain\Model;

use App\Bitres\Shared\Domain\TypedCollection;

final class UserCollection extends TypedCollection
{
  protected function type(): string
  {
    return User::class;
  }
}
