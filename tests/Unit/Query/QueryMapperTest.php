<?php

use Guagua\Query\Exception\QueryIsNotMappedException;
use Guagua\Query\QueryMapper;
use Guagua\ValueObject\Exception\QueryClassIsNotValidException;
use Guagua\ValueObject\QueryClass;
use Tests\Fixture\EmptyQuery;
use Tests\Fixture\EmptyQueryHandler;

use function Pest\Faker\fake;

it('can store a map from a query to its handler', function (string $query, string $handler) {

    $mapper = new QueryMapper([
        $query => $handler,
    ]);

    expect($mapper->get($query)->get())
        ->toBe($handler);

})->with([
    [
        EmptyQuery::class,
        EmptyQueryHandler::class,
    ],
]);

it('can retrieve a map from the query class value object', function (QueryClass $query, string $handler) {

    $mapper = new QueryMapper([
        $query->get() => $handler,
    ]);

    expect($mapper->get($query)->get())
        ->toBe($handler);

})->with([
    [
        new QueryClass(EmptyQuery::class),
        EmptyQueryHandler::class,
    ],
]);

it('throws a query is not mapped exception for unknown querys', function (string $query) {

    $mapper = new QueryMapper([]);

    expect(fn () => $mapper->get($query))
        ->toThrow(QueryIsNotMappedException::class);

})->with([
    EmptyQuery::class,
]);

it('throws a query class is not valid exception for invalid query class names', function (string $query) {

    $mapper = new QueryMapper([]);

    expect(fn () => $mapper->get($query))
        ->toThrow(QueryClassIsNotValidException::class);

})->with([
    fake()->word(),
]);
