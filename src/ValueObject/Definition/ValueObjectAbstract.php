<?php

declare(strict_types=1);

namespace Guagua\ValueObject\Definition;

abstract class ValueObjectAbstract implements ValueObjectInterface
{
    public function get(): mixed
    {
        return null;
    }

    public function equals(ValueObjectInterface $other): bool
    {
        return get_class($other) === get_class($this) &&
            $other->get() === $this->get();
    }

    public static function assertValidness(mixed $value): void
    {
        new static($value);
    }

    public static function isValid(mixed $value): bool
    {
        try {
            self::assertValidness($value);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function __toString(): string
    {
        return (string) $this->get();
    }
}
