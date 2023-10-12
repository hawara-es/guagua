<?php

declare(strict_types=1);

namespace Guagua\Command\Definition;

use Guagua\ValueObject\CommandClass;
use Guagua\ValueObject\CommandHandlerClass;

interface CommandMapperInterface
{
    public function __construct(array $maps);

    public function get(CommandClass|string $command): ?CommandHandlerClass;
}
