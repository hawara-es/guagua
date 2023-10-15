<?php

declare(strict_types=1);

namespace Guagua\Container;

use Guagua\Container\Definition\EventListenerContainerInterface;
use Guagua\Container\Exception\ContainerException;
use Guagua\Container\Exception\NotFoundException;
use Guagua\Event\Definition\EventListenerInterface;
use Guagua\Instancer\Definition\InstancerInterface;
use Guagua\ValueObject\EventListenerClass;

class EventListenerContainer implements EventListenerContainerInterface
{
    public function __construct(
        private InstancerInterface $instancer
    ) {
        //
    }

    public function get(string $id): EventListenerInterface
    {
        if (! $this->has($id)) {
            throw new NotFoundException("Could not find the event listener: $id");
        }

        try {
            return $this->instancer->get($id);
        } catch (\Exception $e) {
            throw new ContainerException($e->getMessage());
        }
    }

    public function has(string $id): bool
    {
        try {
            new EventListenerClass($id);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
