<?php

use Guagua\Instancer\ImplementationSolver;
use Guagua\Instancer\Instancer;
use Guagua\ValueObject\ExistingClass;
use Tests\Fixture\DependentClass;
use Tests\Fixture\EmptyClass;
use Tests\Fixture\EmptyImplementation;
use Tests\Fixture\EmptyInterface;

it('can instance an object of a given class name string', function (string $class) {

    $solver = new ImplementationSolver();
    $instancer = new Instancer($solver);

    expect($instancer->get($class))
        ->toBeObject()
        ->toBeInstanceOf($class);

})->with([
    EmptyClass::class,
]);

it('can instance an object of a given existing class name value object', function (ExistingClass $class) {

    $solver = new ImplementationSolver;
    $instancer = new Instancer($solver);

    expect($instancer->get($class->get()))
        ->toBeObject()
        ->toBeInstanceOf($class->get());

})->with([
    new ExistingClass(EmptyClass::class),
]);

it('can instance an implementation from a string with the name of its interface', function (string $interface, string $implementation) {

    $solver = new ImplementationSolver([
        $interface => $implementation,
    ]);

    $instancer = new Instancer($solver);

    expect($instancer->get($interface))
        ->toBeObject()
        ->toBeInstanceOf($implementation);

})->with([
    [
        EmptyInterface::class,
        EmptyImplementation::class,
    ],
]);

it('can instance an object of a class that depends on another', function (string $class) {

    $solver = new ImplementationSolver;
    $instancer = new Instancer($solver);

    expect($instancer->get($class))
        ->toBeObject()
        ->toBeInstanceOf($class);

})->with([
    DependentClass::class,
]);
