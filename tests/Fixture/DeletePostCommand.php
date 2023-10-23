<?php

declare(strict_types=1);

namespace Tests\Fixture;

use Guagua\Command\Definition\CommandInterface;
use Guagua\ValueObject\Uuid;

class DeletePostCommand implements CommandInterface
{
    private Uuid $commandId;

    public function __construct(
        public readonly string $postId
    ) {
        Uuid::assertValidness($postId);

        $this->commandId = Uuid::random();
    }

    public function getCommandId(): ?Uuid
    {
        return $this->commandId;
    }
}
