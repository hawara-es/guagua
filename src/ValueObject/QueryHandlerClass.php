<?php

declare(strict_types=1);

namespace Guagua\ValueObject;

use Guagua\Query\Definition\QueryHandlerInterface;
use Guagua\ValueObject\Definition\ValueObjectAbstract;
use Guagua\ValueObject\Exception\QueryHandlerClassIsNotValidException;

class QueryHandlerClass extends ValueObjectAbstract
{
    public function __construct(
        private string $handler
    ) {
        if (! class_exists($handler)) {
            throw new QueryHandlerClassIsNotValidException;
        }

        if (! array_key_exists(QueryHandlerInterface::class, class_implements($handler))) {
            throw new QueryHandlerClassIsNotValidException;
        }
    }

    public function get(): string
    {
        return $this->handler;
    }
}
