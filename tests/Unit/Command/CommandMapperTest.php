<?php

use Guagua\Command\CommandMapper;
use Guagua\Command\Exception\CommandIsNotMappedException;
use Guagua\ValueObject\CommandClass;
use Guagua\ValueObject\Exception\CommandClassIsNotValidException;
use Tests\Fixture\EmptyCommand;
use Tests\Fixture\EmptyCommandHandler;

use function Pest\Faker\fake;

it('can store a map from a command to its handler', function (string $command, string $handler) {

    $mapper = new CommandMapper([
        $command => $handler,
    ]);

    expect($mapper->get($command)->get())
        ->toBe($handler);

})->with([
    [
        EmptyCommand::class,
        EmptyCommandHandler::class,
    ],
]);

it('can retrieve a map from the command class value object', function (string $command, string $handler) {

    $mapper = new CommandMapper([
        $command => $handler,
    ]);

    $commandAsValueObject = new CommandClass($command);

    expect($mapper->get($commandAsValueObject)->get())
        ->toBe($handler);

})->with([
    [
        EmptyCommand::class,
        EmptyCommandHandler::class,
    ],
]);

it('throws a command is not mapped exception for unknown commands', function (string $command) {

    $mapper = new CommandMapper([]);

    expect(fn () => $mapper->get($command))
        ->toThrow(CommandIsNotMappedException::class);

})->with([
    EmptyCommand::class,
]);

it('throws a command class is not valid exception for invalid command class names', function (string $command) {

    $mapper = new CommandMapper([]);

    expect(fn () => $mapper->get($command))
        ->toThrow(CommandClassIsNotValidException::class);

})->with([
    fake()->word(),
]);
