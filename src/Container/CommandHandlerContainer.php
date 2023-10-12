<?php

declare(strict_types=1);

namespace Guagua\Container;

use Guagua\Command\Definition\CommandHandlerInterface;
use Guagua\Container\Definition\CommandHandlerContainerInterface;
use Guagua\Container\Exception\ContainerException;
use Guagua\Container\Exception\NotFoundException;
use Guagua\Instancer\Definition\InstancerInterface;
use Guagua\ValueObject\CommandHandlerClass;

class CommandHandlerContainer implements CommandHandlerContainerInterface
{
    public function __construct(
        private InstancerInterface $instancer
    ) {
        //
    }

    public function get(string $id): CommandHandlerInterface
    {
        if (! $this->has($id)) {
            throw new NotFoundException("Could not find the command handler: $id");
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
            new CommandHandlerClass($id);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
