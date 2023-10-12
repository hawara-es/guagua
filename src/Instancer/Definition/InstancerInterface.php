<?php

declare(strict_types=1);

namespace Guagua\Instancer\Definition;

use Guagua\ValueObject\ExistingClass;
use Guagua\ValueObject\ExistingInterface;

interface InstancerInterface
{
    public function get(ExistingClass|ExistingInterface|string $dependency): object;
}
