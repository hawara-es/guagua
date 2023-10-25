<?php

declare(strict_types=1);

namespace Guagua\Command\Implementation\Eloquent;

use Criba\Criteria;
use Guagua\Command\CommandBus;

class AsyncCommandConsumer
{
    public function __construct(
        public CommandRepository $repository,
        public CommandBus $bus
    ) {
        //
    }

    public function consume(Criteria $criteria): void
    {
        $commands = $this->repository->pull($criteria);

        foreach($commands as $command) {
            $this->bus->dispatch($command);
        }
    }
}
