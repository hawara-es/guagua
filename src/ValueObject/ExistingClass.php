<?php

declare(strict_types=1);

namespace Guagua\ValueObject;

use Guagua\ValueObject\Definition\ValueObjectAbstract;
use Guagua\ValueObject\Exception\ExistingClassIsNotValidException;

class ExistingClass extends ValueObjectAbstract
{
    public function __construct(
        private string $class
    ) {
        if (! class_exists($class)) {
            throw new ExistingClassIsNotValidException;
        }
    }

    public function get(): string
    {
        return $this->class;
    }
}
