<?php

declare(strict_types=1);

namespace Guagua\Instancer\Definition;

interface InvokableInterface
{
    /** @param  Guagua\Bus\Command\Definition\CommandInterface|Guagua\Bus\Query\Definition\QueryInterface  $argument */
    public function __invoke($argument);
}
