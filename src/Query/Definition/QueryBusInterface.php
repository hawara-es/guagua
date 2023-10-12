<?php

declare(strict_types=1);

namespace Guagua\Query\Definition;

interface QueryBusInterface
{
    public function ask(QueryInterface $query): ?QueryResponseInterface;
}
