<?php

declare(strict_types=1);

namespace Guagua\Query\Definition;

use Guagua\ValueObject\QueryClass;
use Guagua\ValueObject\QueryHandlerClass;

interface QueryMapperInterface
{
    public function __construct(array $maps);

    public function get(QueryClass|string $command): ?QueryHandlerClass;
}
