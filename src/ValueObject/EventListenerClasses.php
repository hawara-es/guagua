<?php

declare(strict_types=1);

namespace Guagua\ValueObject;

use Guagua\ValueObject\Definition\ValueObjectAbstract;

class EventListenerClasses extends ValueObjectAbstract
{
    private array $listeners = [];

    public function __construct(
        array $listeners = []
    ) {
        foreach ($listeners as $listener) {
            EventListenerClass::assertValidness($listener);

            $this->listeners[] = $listener;
        }
    }

    public function get(): array
    {
        return $this->listeners;
    }
}
