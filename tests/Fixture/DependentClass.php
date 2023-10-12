<?php

declare(strict_types=1);

namespace Tests\Fixture;

class DependentClass
{
    public function __construct(
        public EmptyImplementation $dependency
    ) {
        //
    }
}
