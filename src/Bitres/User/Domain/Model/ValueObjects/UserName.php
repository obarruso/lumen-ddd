<?php

declare(strict_types=1);

namespace App\Bitres\User\Domain\Model\ValueObjects;

use App\Common\Domain\Exceptions\RequiredException;
use App\Common\Domain\ValueObject;

final class UserName extends ValueObject
{
    private string $name;

    public function __construct(?string $name)
    {

        if (!$name) {
            throw new RequiredException('username');
        }

        $this->name = $name;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function jsonSerialize(): string
    {
        return $this->name;
    }
}