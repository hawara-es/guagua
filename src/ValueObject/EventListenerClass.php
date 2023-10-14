<?php

declare(strict_types=1);

namespace Guagua\ValueObject;

use Guagua\Event\Definition\EventListenerInterface;
use Guagua\ValueObject\Definition\ValueObjectAbstract;
use Guagua\ValueObject\Exception\EventListenerClassIsNotValidException;

class EventListenerClass extends ValueObjectAbstract
{
    public function __construct(
        private string $listener
    ) {
        if (! class_exists($listener)) {
            throw new EventListenerClassIsNotValidException("The event listener ($listener) is not valid");
        }

        if (! array_key_exists(EventListenerInterface::class, class_implements($listener))) {
            throw new EventListenerClassIsNotValidException("The event listener ($listener) does not implement the event listener interface");
        }
    }

    public function get(): string
    {
        return $this->listener;
    }
}
