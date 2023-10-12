<?php

declare(strict_types=1);

namespace Guagua\Command\Definition;

use Guagua\ValueObject\CommandClass;

abstract class CommandAbstract implements CommandInterface
{
    public function getCommandClass(): CommandClass
    {
        return new CommandClass(static::class);
    }
}
