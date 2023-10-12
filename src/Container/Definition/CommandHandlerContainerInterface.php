<?php

declare(strict_types=1);

namespace Guagua\Container\Definition;

use Guagua\Command\Definition\CommandHandlerInterface;
use Psr\Container\ContainerInterface;

interface CommandHandlerContainerInterface extends ContainerInterface
{
    public function get(string $id): CommandHandlerInterface;

    public function has(string $id): bool;
}
