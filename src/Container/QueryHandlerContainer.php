<?php

declare(strict_types=1);

namespace Guagua\Container;

use Guagua\Container\Definition\QueryHandlerContainerInterface;
use Guagua\Container\Exception\ContainerException;
use Guagua\Container\Exception\NotFoundException;
use Guagua\Instancer\Definition\InstancerInterface;
use Guagua\Query\Definition\QueryHandlerInterface;
use Guagua\ValueObject\QueryHandlerClass;

class QueryHandlerContainer implements QueryHandlerContainerInterface
{
    public function __construct(
        private InstancerInterface $instancer
    ) {
        //
    }

    public function get(string $id): QueryHandlerInterface
    {
        if (! $this->has($id)) {
            throw new NotFoundException("Could not find the query handler: $id");
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
            new QueryHandlerClass($id);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
