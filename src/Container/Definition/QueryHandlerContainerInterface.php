<?php

declare(strict_types=1);

namespace Guagua\Container\Definition;

use Guagua\Query\Definition\QueryHandlerInterface;
use Psr\Container\ContainerInterface;

interface QueryHandlerContainerInterface extends ContainerInterface
{
    public function get(string $id): QueryHandlerInterface;

    public function has(string $id): bool;
}
