<?php

use Guagua\Instancer\Exception\ClassDoesNotImplementTheInterfaceException;
use Guagua\Instancer\ImplementationSolver;
use Tests\Fixture\EmptyClass;
use Tests\Fixture\EmptyImplementation;
use Tests\Fixture\EmptyInterface;

it('can relate an interface to an implementation', function ($interface, $implementation) {

    $solver = new ImplementationSolver([
        $interface => $implementation,
    ]);

    expect($solver->get($interface)->get())
        ->toBe($implementation);

})->with([
    [
        EmptyInterface::class,
        EmptyImplementation::class,
    ],
]);

it('rejects a pair if the class does not implement the interface', function ($interface, $implementation) {

    $implementations = [
        $interface => $implementation,
    ];

    expect(fn () => new ImplementationSolver($implementations))
        ->toThrow(ClassDoesNotImplementTheInterfaceException::class);

})->with([
    [
        EmptyInterface::class,
        EmptyClass::class,
    ],
]);
