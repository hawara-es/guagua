<?php

declare(strict_types=1);

namespace Guagua\Instancer;

use Guagua\Instancer\Definition\ImplementationSolverInterface;
use Guagua\Instancer\Exception\ClassDoesNotImplementTheInterfaceException;
use Guagua\Instancer\Exception\ImplementationCouldNotBeSolvedException;
use Guagua\ValueObject\ExistingClass;
use Guagua\ValueObject\ExistingInterface;

class ImplementationSolver implements ImplementationSolverInterface
{
    private array $implementations = [];

    public function __construct(array $implementations = [])
    {
        foreach ($implementations as $interface => $class) {
            $interface = new ExistingInterface($interface);
            $class = new ExistingClass($class);

            if (! in_array($interface->get(), class_implements($class->get()))) {
                throw new ClassDoesNotImplementTheInterfaceException;
            }

            $this->implementations[$interface->get()] = $class;
        }
    }

    public function get(ExistingInterface|string $interface): ExistingClass
    {
        if (is_string($interface)) {
            $interface = new ExistingInterface($interface);
        }

        if (! array_key_exists($interface->get(), $this->implementations)) {
            throw new ImplementationCouldNotBeSolvedException($interface->get());
        }

        return $this->implementations[$interface->get()];
    }
}
