<?php

declare(strict_types=1);

namespace Guagua\Command;

use Guagua\Command\Definition\CommandBusInterface;
use Guagua\Command\Definition\CommandInterface;
use Guagua\Command\Definition\CommandMapperInterface;
use Guagua\Container\Definition\CommandHandlerContainerInterface;

class CommandBus implements CommandBusInterface
{
    public function __construct(
        private CommandMapperInterface $mapper,
        private CommandHandlerContainerInterface $container
    ) {
        //
    }

    public function dispatch(CommandInterface $command): void
    {
        $commandHandlerClass = $this->mapper->get($command::class);
        $commandHandler = $this->container->get($commandHandlerClass->get());

        $commandHandler->__invoke($command);
    }
}
