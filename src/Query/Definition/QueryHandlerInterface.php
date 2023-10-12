<?php

declare(strict_types=1);

namespace Guagua\Query\Definition;

use Guagua\Instancer\Definition\InvokableInterface;

interface QueryHandlerInterface extends InvokableInterface
{
    /** @param  QueryInterface  $argument */
    public function __invoke($argument): QueryResponseInterface;
}
