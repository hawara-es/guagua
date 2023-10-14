<?php

use Guagua\Event\Exception\EventIsNotMappedException;
use Guagua\Event\EventMapper;
use Guagua\ValueObject\Exception\EventClassIsNotValidException;
use Guagua\ValueObject\EventClass;
use Tests\Fixture\DoNothingOnEmptyEvent;
use Tests\Fixture\EmptyEvent;

use function Pest\Faker\fake;

it('can store a map from a event to its listeners', function (string $event, array $listeners) {

    $mapper = new EventMapper([
        $event => $listeners,
    ]);

    expect($mapper->get($event)->get())
        ->toBeArray()
        ->toHaveLength(count($listeners))
        ->toMatchArray($listeners);

})->with([
    [
        EmptyEvent::class,
        [
            DoNothingOnEmptyEvent::class,
            DoNothingOnEmptyEvent::class,
        ],
    ],
]);

it('can retrieve a map from the event class value object', function (EventClass $event, array $listeners) {

    $mapper = new EventMapper([
        $event->get() => $listeners,
    ]);

    expect($mapper->get($event)->get())
        ->toBeArray()
        ->toHaveLength(count($listeners))
        ->toMatchArray($listeners);

})->with([
    [
        new EventClass(EmptyEvent::class),
        [
            DoNothingOnEmptyEvent::class,
        ],
    ],
]);

it('throws a event is not mapped exception for unknown events', function (string $event) {

    $mapper = new EventMapper([]);

    expect(fn () => $mapper->get($event))
        ->toThrow(EventIsNotMappedException::class);

})->with([
    EmptyEvent::class,
]);

it('throws a event class is not valid exception for invalid event class names', function (string $event) {

    $mapper = new EventMapper([]);

    expect(fn () => $mapper->get($event))
        ->toThrow(EventClassIsNotValidException::class);

})->with([
    fake()->word(),
]);
