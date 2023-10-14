<?php

declare(strict_types=1);

namespace Tests\Fixture;

use Guagua\Event\Definition\EventInterface;
use Guagua\Event\Definition\EventListenerInterface;

class DoNothingOnEmptyEvent implements EventListenerInterface
{
    /** @param  EmptyEvent  $event */
    public function __invoke(EventInterface $event): void
    {
        //
    }
}
