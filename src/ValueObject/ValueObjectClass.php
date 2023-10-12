<?php

declare(strict_types=1);

namespace Guagua\ValueObject;

use Guagua\ValueObject\Definition\ValueObjectAbstract;
use Guagua\ValueObject\Definition\ValueObjectInterface;
use Guagua\ValueObject\Exception\ValueObjectClassIsNotValidException;

class ValueObjectClass extends ValueObjectAbstract
{
    public function __construct(
        private string $valueObject
    ) {
        if (! class_exists($valueObject)) {
            throw new ValueObjectClassIsNotValidException;
        }

        if (! array_key_exists(ValueObjectInterface::class, class_implements($valueObject))) {
            throw new ValueObjectClassIsNotValidException;
        }
    }

    public function get(): string
    {
        return $this->valueObject;
    }
}
