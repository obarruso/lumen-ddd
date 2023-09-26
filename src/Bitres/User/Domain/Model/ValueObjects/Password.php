<?php

declare(strict_types=1);

namespace App\Bitres\User\Domain\Model\ValueObjects;

use App\Common\Domain\ValueObject;
use App\Bitres\User\Domain\Exceptions\PasswordsDoNotMatchException;
use App\Bitres\User\Domain\Exceptions\PasswordTooShortException;

final class Password extends ValueObject
{
    public readonly ?string $value;

    public function __construct(?string $password, ?string $confirmation)
    {
        if ($password && strlen($password) < 8) {
            throw new PasswordTooShortException();
        }

        if ($password !== $confirmation) {
            throw new PasswordsDoNotMatchException();
        }

        $this->value = $password;
    }

    public static function fromString(string $password, string $confirmation): self
    {
        return new self($password, $confirmation);
    }

    public function isNotEmpty(): bool
    {
        return $this->value !== null;
    }

    public function jsonSerialize(): string
    {
        return '';
    }
}