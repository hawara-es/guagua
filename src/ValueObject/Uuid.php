<?php

declare(strict_types=1);

namespace Guagua\ValueObject;

use Guagua\ValueObject\Exception\UuidIsNotValidException;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid
{
    public function __construct(
        private string $uuid
    ) {
        if(! RamseyUuid::isValid($uuid)) {
            throw new UuidIsNotValidException("The UUID ($uuid) is not valid");
        }
    }

    public static function random(): self
    {
        return new self((string) RamseyUuid::uuid4());
    }

    public function get(): string
    {
        return $this->uuid;
    }
}