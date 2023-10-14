<?php

declare(strict_types=1);

namespace Guagua\Event;

use Guagua\Event\Definition\EventMapperInterface;
use Guagua\Event\Exception\EventIsNotMappedException;
use Guagua\ValueObject\EventClass;
use Guagua\ValueObject\EventListenerClasses;

class EventMapper implements EventMapperInterface
{
    private array $maps = [];

    public function __construct(array $maps)
    {
        foreach ($maps as $event => $listeners) {
            EventClass::assertValidness($event);

            $this->maps[$event] = new EventListenerClasses($listeners);
        }
    }

    public function get(EventClass|string $event): EventListenerClasses
    {
        if (is_string($event)) {
            $event = new EventClass($event);
        }

        if (! array_key_exists($event->get(), $this->maps)) {
            throw new EventIsNotMappedException;
        }

        return $this->maps[$event->get()];
    }
}
