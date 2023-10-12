<?php

declare(strict_types=1);

namespace Guagua\Command;

use Guagua\Command\Definition\CommandMapperInterface;
use Guagua\Command\Exception\CommandIsNotMappedException;
use Guagua\ValueObject\CommandClass;
use Guagua\ValueObject\CommandHandlerClass;

class CommandMapper implements CommandMapperInterface
{
    private array $maps = [];

    public function __construct(array $maps = [])
    {
        foreach ($maps as $command => $handler) {
            $this->maps[(new CommandClass($command))->get()] = new CommandHandlerClass($handler);
        }
    }

    public function get(CommandClass|string $command): CommandHandlerClass
    {
        if (is_string($command)) {
            $command = new CommandClass($command);
        }

        if (! array_key_exists($command->get(), $this->maps)) {
            throw new CommandIsNotMappedException;
        }

        return $this->maps[$command->get()];
    }
}
