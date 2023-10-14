<?php

declare(strict_types=1);

namespace Guagua\Event\Definition;

interface EventBusInterface
{
    public function publish(EventInterface ...$events): void;
}
