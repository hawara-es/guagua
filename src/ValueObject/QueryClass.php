<?php

declare(strict_types=1);

namespace Guagua\ValueObject;

use Guagua\Query\Definition\QueryInterface;
use Guagua\ValueObject\Definition\ValueObjectAbstract;
use Guagua\ValueObject\Exception\QueryClassIsNotValidException;

class QueryClass extends ValueObjectAbstract
{
    public function __construct(
        private string $query
    ) {
        if (! class_exists($query)) {
            throw new QueryClassIsNotValidException("The query ($query) is not valid");
        }

        if (! array_key_exists(QueryInterface::class, class_implements($query))) {
            throw new QueryClassIsNotValidException("The query ($query) does not implement the query interface");
        }
    }

    public function get(): string
    {
        return $this->query;
    }
}
