<?php

declare(strict_types=1);

namespace Guagua\Command\Definition;

use Guagua\Instancer\Definition\InvokableInterface;

interface CommandHandlerInterface extends InvokableInterface
{
    /** @param  CommandInterface  $argument */
    public function __invoke($argument): void;
}
