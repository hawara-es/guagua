<?php

declare(strict_types=1);

namespace Guagua\Instancer;

use Guagua\Instancer\Definition\ImplementationSolverInterface;
use Guagua\Instancer\Definition\InstancerInterface;
use Guagua\Instancer\Exception\DependencyCouldNotBeInstancedException;
use Guagua\ValueObject\ExistingClass;
use Guagua\ValueObject\ExistingInterface;

class Instancer implements InstancerInterface
{
    private ImplementationSolver $solver;

    public function __construct(
        ImplementationSolverInterface $solver = null
    ) {
        if (! $solver) {
            $solver = new ImplementationSolver();
        }

        $this->solver = $solver;
    }

    public function get(ExistingClass|ExistingInterface|string $dependency): object
    {
        $class = $this->getExistingClass($dependency);

        $reflection = new \ReflectionClass($class->get());

        $parameters = $this->getConstructorParameters($reflection);

        $instance = $reflection->newInstanceArgs($parameters);

        if (! is_object($instance)) {
            throw new DependencyCouldNotBeInstancedException('The instancer expected an object but obtained something else');
        }

        return $instance;
    }

    private function getExistingClass(ExistingClass|ExistingInterface|string $dependency): ExistingClass
    {
        if ($dependency instanceof ExistingClass) {
            return $dependency;
        }

        if ($dependency instanceof ExistingInterface) {
            return $this->solver->get($dependency);
        }

        if (is_string($dependency) && interface_exists($dependency)) {
            return $this->solver->get($dependency);
        }

        try {
            return new ExistingClass($dependency);
        } catch (\Exception $e) {
            throw new DependencyCouldNotBeInstancedException($e->getMessage());
        }
    }

    private function getConstructorParameters(\ReflectionClass $reflection): array
    {
        $constructor = $reflection->getConstructor();

        if (! $constructor) {
            return [];
        }

        $parameters = [];

        foreach ($constructor->getParameters() as $parameter) {
            $dependency = $parameter->getType()->getName();

            if (! class_exists($dependency) && ! interface_exists($dependency)) {
                $parameters[$parameter->getName()] = $parameter->getDefaultValue();

                continue;
            }

            $parameters[$parameter->getName()] = $this->get($dependency);
        }

        return $parameters;
    }
}
