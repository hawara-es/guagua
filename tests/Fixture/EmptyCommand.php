<?php

declare(strict_types=1);

namespace Tests\Fixture;

use Guagua\Command\Definition\CommandInterface;
use Guagua\ValueObject\Uuid;

class EmptyCommand implements CommandInterface
{
    private Uuid $commandId;

    public function __construct()
    {
        $this->commandId = Uuid::random();
    }

    public function getCommandId(): ?Uuid
    {
        return $this->commandId;
    }
}
