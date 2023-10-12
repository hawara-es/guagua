<?php

use Guagua\Command\CommandBus;
use Guagua\Command\CommandMapper;
use Guagua\Container\CommandHandlerContainer;
use Guagua\Instancer\Instancer;
use Guagua\ValueObject\CommandHandlerClass;
use Mockery as Mockery;
use Tests\Fixture\EmptyCommand;
use Tests\Fixture\EmptyCommandHandler;

it('uses the command mapper to obtain the corresponding command handler', function (string $command, string $handler) {

    $mapper = new CommandMapper([
        $command => $handler,
    ]);

    /** @var Guagua\Command\Definition\CommandMapperInterface|Mockery\MockInterface $mapperMock */
    $mapperMock = Mockery::mock($mapper);
    $container = (new Instancer())->get(CommandHandlerContainer::class);
    $commandBus = new CommandBus($mapperMock, $container);

    $mapperMock->shouldReceive('get')
        ->once()
        ->andReturn(new CommandHandlerClass($handler));

    $commandBus->dispatch(new $command);

})->with([
    [
        EmptyCommand::class,
        EmptyCommandHandler::class,
    ],
]);

it('uses the command handler container to get the corresponding command handler', function (string $command, string $handler) {

    $mapper = new CommandMapper([
        $command => $handler,
    ]);

    $container = (new Instancer)->get(CommandHandlerContainer::class);

    /** @var Guagua\Container\CommandHandlerContainer|Mockery\MockInterface $containerMock */
    $containerMock = Mockery::mock($container);

    $commandBus = new CommandBus($mapper, $containerMock);

    $containerMock->shouldReceive('get')
        ->once()
        ->with($handler)
        ->andReturn(new $handler);

    $commandBus->dispatch(new $command);

})->with([
    [
        EmptyCommand::class,
        EmptyCommandHandler::class,
    ],
]);
