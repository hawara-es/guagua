<?php

declare(strict_types=1);

namespace Guagua\Command\Implementation\Eloquent;

use Guagua\Command\Definition\AsyncCommandBusInterface;
use Guagua\Command\Definition\CommandInterface;

class AsyncCommandBus implements AsyncCommandBusInterface
{
    public function __construct(
        private CommandRepository $repository
    ) {
        //
    }

    public function dispatch(CommandInterface $command): void
    {
        $this->repository->save($command);
    }
}
