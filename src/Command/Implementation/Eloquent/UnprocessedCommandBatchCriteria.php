<?php

declare(strict_types=1);

namespace Guagua\Command\Implementation\Eloquent;

use Criba\Condition;
use Criba\Criteria;
use Criba\Filter;
use Criba\OrderBy;
use Criba\Page;

class UnprocessedCommandBatchCriteria extends Criteria
{
    public function __construct()
    {
        parent::__construct(
            new Filter(
                new Condition('processed_at', '=', null),
            ),
            new OrderBy(['created_at' => 'asc']),
            new Page(25, 0)
        );
    }
}
