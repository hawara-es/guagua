<?php

declare(strict_types=1);

namespace Guagua\Query;

use Guagua\Query\Definition\QueryMapperInterface;
use Guagua\Query\Exception\QueryIsNotMappedException;
use Guagua\ValueObject\QueryClass;
use Guagua\ValueObject\QueryHandlerClass;

class QueryMapper implements QueryMapperInterface
{
    private array $maps = [];

    public function __construct(array $maps)
    {
        foreach ($maps as $query => $handler) {
            $this->maps[(new QueryClass($query))->get()] = new QueryHandlerClass($handler);
        }
    }

    public function get(QueryClass|string $query): QueryHandlerClass
    {
        if (is_string($query)) {
            $query = new QueryClass($query);
        }

        if (! array_key_exists($query->get(), $this->maps)) {
            throw new QueryIsNotMappedException;
        }

        return $this->maps[$query->get()];
    }
}
