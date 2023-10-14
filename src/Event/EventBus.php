<?php

declare(strict_types=1);

namespace Guagua\Event\Definition;

use Guagua\Instancer\Definition\InstancerInterface;
use Guagua\ValueObject\EventListenerClasses;

class EventBus
{
    public function __construct(
        private EventMapperInterface $mapper,
        private InstancerInterface $instancer
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
        foreach($listeners->get() as $listenerClass) {
            $listener = $this->instancer->get($listenerClass);

            $listener->__invoke($event);
        }
    }
}
