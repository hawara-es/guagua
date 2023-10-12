<?php

declare(strict_types=1);

namespace Guagua\ValueObject\Definition;

interface ValueObjectInterface
{
    public function get(): mixed;

    public function equals(ValueObjectInterface $other): bool;

    public function __toString(): string;
}
