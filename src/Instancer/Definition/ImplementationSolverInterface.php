<?php

declare(strict_types=1);

namespace Guagua\Instancer\Definition;

use Guagua\ValueObject\ExistingClass;
use Guagua\ValueObject\ExistingInterface;

interface ImplementationSolverInterface
{
    public function __construct(array $implementations = []);

    public function get(ExistingInterface|string $interface): ExistingClass;
}
