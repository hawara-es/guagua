<?php

declare(strict_types=1);

namespace Guagua\Query\Definition;

use Guagua\ValueObject\QueryClass;

interface QueryInterface
{
    public function getQueryClass(): QueryClass;
}
