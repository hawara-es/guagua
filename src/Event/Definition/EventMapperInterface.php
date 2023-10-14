<?php

declare(strict_types=1);

namespace Guagua\Event\Definition;

use Guagua\ValueObject\EventClass;
use Guagua\ValueObject\EventListenerClasses;

interface EventMapperInterface
{
    public function __construct(array $maps);

    public function get(EventClass|string $command): ?EventListenerClasses;
}
