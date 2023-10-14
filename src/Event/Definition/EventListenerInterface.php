<?php

declare(strict_types=1);

namespace Guagua\Event\Definition;

interface EventListenerInterface
{
    public function __invoke(EventInterface $event): void;
}
