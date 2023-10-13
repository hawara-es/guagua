<?php

declare(strict_types=1);

namespace Guagua\ValueObject;

use Guagua\Command\Definition\CommandHandlerInterface;
use Guagua\ValueObject\Definition\ValueObjectAbstract;
use Guagua\ValueObject\Exception\CommandHandlerClassIsNotValidException;

class CommandHandlerClass extends ValueObjectAbstract
{
    public function __construct(
        private string $handler
    ) {
        if (! class_exists($handler)) {
            throw new CommandHandlerClassIsNotValidException("The command handler ($handler) is not valid");
        }

        if (! array_key_exists(CommandHandlerInterface::class, class_implements($handler))) {
            throw new CommandHandlerClassIsNotValidException("The command handler ($handler) does not implement the command handler interface");
        }
    }

    public function get(): string
    {
        return $this->handler;
    }
}
