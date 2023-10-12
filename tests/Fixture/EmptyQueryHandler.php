<?php

declare(strict_types=1);

namespace Tests\Fixture;

use Guagua\Query\Definition\QueryHandlerInterface;
use Guagua\Query\Definition\QueryResponseInterface;

class EmptyQueryHandler implements QueryHandlerInterface
{
    public function __invoke($argument): QueryResponseInterface
    {
        return new EmptyQueryResponse;
    }
}
