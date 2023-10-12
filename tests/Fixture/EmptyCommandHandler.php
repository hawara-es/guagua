<?php

declare(strict_types=1);

namespace Tests\Fixture;

use Guagua\Command\Definition\CommandHandlerInterface;

class EmptyCommandHandler implements CommandHandlerInterface
{
    public function __invoke($command): void
    {
        //
    }
}
