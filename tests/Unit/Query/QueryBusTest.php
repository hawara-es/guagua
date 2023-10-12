<?php

use Guagua\Container\QueryHandlerContainer;
use Guagua\Instancer\Instancer;
use Guagua\Query\QueryBus;
use Guagua\Query\QueryMapper;
use Guagua\ValueObject\QueryHandlerClass;
use Tests\Fixture\EmptyQuery;
use Tests\Fixture\EmptyQueryHandler;

it('uses the query mapper to obtain the corresponding query handler', function (string $query, string $handler) {

    $mapper = new QueryMapper([
        $query => $handler,
    ]);

    /** @var Guagua\Query\Definition\QueryMapperInterface|Mockery\MockInterface $mapperMock */
    $mapperMock = Mockery::mock($mapper);
    $container = (new Instancer())->get(QueryHandlerContainer::class);
    $queryBus = new QueryBus($mapperMock, $container);

    $mapperMock->shouldReceive('get')
        ->once()
        ->andReturn(new QueryHandlerClass($handler));

    $queryBus->ask(new $query);

})->with([
    [
        EmptyQuery::class,
        EmptyQueryHandler::class,
    ],
]);

it('uses the query handler container to get the corresponding query handler', function (string $query, string $handler) {

    $mapper = new QueryMapper([
        $query => $handler,
    ]);

    $container = (new Instancer)->get(QueryHandlerContainer::class);

    /** @var Guagua\Container\QueryHandlerContainer|Mockery\MockInterface $containerMock */
    $containerMock = Mockery::mock($container);

    $queryBus = new QueryBus($mapper, $containerMock);

    $containerMock->shouldReceive('get')
        ->once()
        ->with($handler)
        ->andReturn(new $handler);

    $queryBus->ask(new $query);

})->with([
    [
        EmptyQuery::class,
        EmptyQueryHandler::class,
    ],
]);
