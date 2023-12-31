<?php

declare(strict_types=1);

namespace Guagua\ValueObject;

use Guagua\Command\Definition\CommandInterface;
use Guagua\ValueObject\Definition\ValueObjectAbstract;
use Guagua\ValueObject\Exception\CommandClassIsNotValidException;

class CommandClass extends ValueObjectAbstract
{
    public function __construct(
        private string $command
    ) {
        if (! class_exists($command)) {
            throw new CommandClassIsNotValidException("The command ($command) is not valid");
        }

        if (! array_key_exists(CommandInterface::class, class_implements($command))) {
            throw new CommandClassIsNotValidException("The command ($command) does not implement the command interface");
        }
    }

    public function get(): string
    {
        return $this->command;
    }
}
