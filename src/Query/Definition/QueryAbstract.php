<?php

declare(strict_types=1);

namespace Guagua\Query\Definition;

use Guagua\ValueObject\QueryClass;

abstract class QueryAbstract implements QueryInterface
{
    public function getQueryClass(): QueryClass
    {
        return new QueryClass(static::class);
    }
}
