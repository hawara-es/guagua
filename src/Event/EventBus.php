<?php

declare(strict_types=1);

namespace Guagua\Event;

use Guagua\Container\Definition\EventListenerContainerInterface;
use Guagua\Event\Definition\EventInterface;
use Guagua\Event\Definition\EventMapperInterface;
use Guagua\ValueObject\EventListenerClasses;

class EventBus
{
    public function __construct(
        private EventMapperInterface $mapper,
        private EventListenerContainerInterface $container
    ) {
        //
    }

    public function publish(EventInterface ...$events): void
    {
        foreach ($events as $event) {
            $listeners = $this->mapper->get($event::class);

            $this->dispatch($listeners, $event);
        }
    }

    private function dispatch(EventListenerClasses $listeners, EventInterface $event)
    {
        foreach ($listeners->get() as $listenerClass) {
            $listener = $this->container->get($listenerClass);

            $listener->__invoke($event);
        }
    }
}
