<?php

declare(strict_types=1);

namespace Guagua\ValueObject;

use Guagua\ValueObject\Exception\CommandClassIsNotValidException;
use Guagua\Command\Definition\CommandInterface;
use Guagua\ValueObject\Definition\ValueObjectAbstract;

class CommandClass extends ValueObjectAbstract
{
    public function __construct(
        private string $command
    ) {
        if (! class_exists($command)) {
            throw new CommandClassIsNotValidException;
        }

        if (! array_key_exists(CommandInterface::class, class_implements($command))) {
            throw new CommandClassIsNotValidException;
        }
    }

    public function get(): string
    {
        return $this->command;
    }
}
