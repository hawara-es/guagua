<?php

declare(strict_types=1);

namespace Guagua\Command\Definition;

use Guagua\ValueObject\Uuid;

interface CommandInterface
{
    public function getCommandId(): ?Uuid;
}
