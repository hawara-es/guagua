<?php

declare(strict_types=1);

namespace Guagua\Container\Definition;

use Guagua\Event\Definition\EventListenerInterface;
use Psr\Container\ContainerInterface;

interface EventListenerContainerInterface extends ContainerInterface
{
    public function get(string $id): EventListenerInterface;

    public function has(string $id): bool;
}
