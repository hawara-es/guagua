<?php

declare(strict_types=1);

namespace Guagua\Command\Definition;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): void;
}
