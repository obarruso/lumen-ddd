<?php

declare(strict_types=1);

namespace App\Bitres\Shared\Domain\Model\ValueObjects;

use App\Common\Domain\Exceptions\RequiredException;
use App\Common\Domain\ValueObject;

final class Uuid extends ValueObject
{
    private string $uuid;

    public function __construct(?string $uuid)
    {

        if (!$uuid) {
            throw new RequiredException('uuid');
        }

        $this->uuid = $uuid;
    }

    public function __toString(): string
    {
        return $this->uuid;
    }

    public function jsonSerialize(): string
    {
        return $this->uuid;
    }
}