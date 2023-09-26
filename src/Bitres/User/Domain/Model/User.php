<?php

declare(strict_types=1);

namespace App\Bitres\User\Domain\Model;

use App\Common\Domain\AggregateRoot;
use App\Bitres\Shared\Domain\Model\ValueObjects\Uuid;
use App\Bitres\User\Domain\Model\ValueObjects\Email;
use App\Bitres\User\Domain\Model\ValueObjects\UserName;

class User extends AggregateRoot
{
  public function __construct(
    public readonly Uuid $uuid,
    public readonly UserName $username,
    public readonly Email $email,
    public readonly bool $is_admin = false,
    public readonly bool $is_active = true
  ) {
  }
  public function toArray(): array
  {
    return [
      'uuid' => $this->uuid,
      'username' => $this->username,
      'email' => $this->email,
      'is_admin' => $this->is_admin,
      'is_active' => $this->is_active,
    ];
  }
}
