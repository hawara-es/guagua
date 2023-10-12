<?php

declare(strict_types=1);

namespace Guagua\Instancer;

class Implementations
{
    public static function get(): array
    {
        return [
            \Guagua\Command\Definition\CommandBusInterface::class => \Guagua\Command\CommandBus::class,
            \Guagua\Command\Definition\CommandMapperInterface::class => \Guagua\Command\CommandMapper::class,
            \Guagua\Container\Definition\CommandHandlerContainerInterface::class => \Guagua\Container\CommandHandlerContainer::class,
            \Guagua\Instancer\Definition\ImplementationSolverInterface::class => \Guagua\Instancer\ImplementationSolver::class,
            \Guagua\Instancer\Definition\InstancerInterface::class => \Guagua\Instancer\Instancer::class,
        ];
    }
}