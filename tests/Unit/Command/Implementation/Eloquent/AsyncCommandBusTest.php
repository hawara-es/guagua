<?php

use Guagua\Command\Implementation\Eloquent\AsyncCommandBus;
use Guagua\Command\Implementation\Eloquent\CommandModel;
use Guagua\Command\Implementation\Eloquent\CommandRepository;
use Guagua\Command\Implementation\Eloquent\UnprocessedCommandBatchCriteria;
use Guagua\ValueObject\Uuid;
use Tests\Fixture\DeletePostCommand;
use Tests\Fixture\EmptyCommand;

beforeEach(fn () => $this->bootEloquent());

it('can store commands in the command repository', function (EmptyCommand $command) {

    $commandBus = new AsyncCommandBus(new CommandRepository);
    $commandBus->dispatch($command);

    expect(CommandModel::whereId((string) $command->getCommandId())->count())->toBe(1);

})->with([
    [
        new EmptyCommand(),
    ],
]);

it('can pull stored commands from the command repository', function (DeletePostCommand $command) {

    $repository = new CommandRepository;
    $commandBus = new AsyncCommandBus($repository);
    $commandBus->dispatch($command);

    $criteria = new UnprocessedCommandBatchCriteria;

    $pulled = $repository->pull($criteria);
    expect(count($pulled))->toBe(1);

    $pulled = $repository->pull($criteria);
    expect(count($pulled))->toBe(0);

})->with([
    [
        new DeletePostCommand((string) Uuid::random()),
    ],
]);
