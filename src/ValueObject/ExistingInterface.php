<?php

declare(strict_types=1);

namespace Guagua\ValueObject;

use Guagua\ValueObject\Definition\ValueObjectAbstract;
use Guagua\ValueObject\Exception\ExistingInterfaceIsNotValidException;

class ExistingInterface extends ValueObjectAbstract
{
    public function __construct(
        private string $interface
    ) {
        if (! interface_exists($interface)) {
            throw new ExistingInterfaceIsNotValidException;
        }
    }

    public function get(): string
    {
        return $this->interface;
    }
}
