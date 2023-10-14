<?php

declare(strict_types=1);

namespace Guagua\ValueObject;

use Guagua\Event\Definition\EventInterface;
use Guagua\ValueObject\Definition\ValueObjectAbstract;
use Guagua\ValueObject\Exception\EventClassIsNotValidException;

class EventClass extends ValueObjectAbstract
{
    public function __construct(
        private string $event
    ) {
        if (! class_exists($event)) {
            throw new EventClassIsNotValidException("The event ($event) is not valid");
        }

        if (! array_key_exists(EventInterface::class, class_implements($event))) {
            throw new EventClassIsNotValidException("The event ($event) does not implement the event interface");
        }
    }

    public function get(): string
    {
        return $this->event;
    }
}
