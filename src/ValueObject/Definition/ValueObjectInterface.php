<?php

declare(strict_types=1);

namespace Guagua\ValueObject\Definition;

interface ValueObjectInterface
{
    public function get(): mixed;

    public function equals(ValueObjectInterface $other): bool;

    public static function assertValidness(mixed $value): void;

    public static function isValid(mixed $value): bool;

    public function __toString(): string;
}
