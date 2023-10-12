<?php

declare(strict_types=1);

namespace Guagua\Command\Definition;

use Guagua\ValueObject\CommandClass;

interface CommandInterface
{
    public function getCommandClass(): CommandClass;
}
