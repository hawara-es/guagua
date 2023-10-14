<?php

declare(strict_types=1);

namespace Guagua\Query;

use Guagua\Container\QueryHandlerContainer;
use Guagua\Query\Definition\QueryBusInterface;
use Guagua\Query\Definition\QueryInterface;
use Guagua\Query\Definition\QueryMapperInterface;
use Guagua\Query\Definition\QueryResponseInterface;

class QueryBus implements QueryBusInterface
{
    public function __construct(
        private QueryMapperInterface $mapper,
        private QueryHandlerContainer $container
    ) {
        //
    }

    public function ask(QueryInterface $query): QueryResponseInterface
    {
        $queryHandlerClass = $this->mapper->get($query::class);
        $queryHandler = $this->container->get($queryHandlerClass->get());

        return $queryHandler->__invoke($query);
    }
}
