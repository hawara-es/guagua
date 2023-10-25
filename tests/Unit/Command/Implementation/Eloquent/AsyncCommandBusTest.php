<?php

use Guagua\Command\CommandBus;
use Guagua\Command\CommandMapper;
use Guagua\Command\Definition\CommandHandlerInterface;
use Guagua\Command\Definition\CommandInterface;
use Guagua\Command\Implementation\Eloquent\AsyncCommandBus;
use Guagua\Command\Implementation\Eloquent\AsyncCommandConsumer;
use Guagua\Command\Implementation\Eloquent\CommandModel;
use Guagua\Command\Implementation\Eloquent\CommandRepository;
use Guagua\Command\Implementation\Eloquent\UnprocessedCommandBatchCriteria;
use Guagua\Container\CommandHandlerContainer;
use Guagua\Instancer\Instancer;
use Guagua\ValueObject\Uuid;
use Tests\Fixture\DeletePostCommand;
use Tests\Fixture\EmptyCommand;

beforeEach(fn () => $this->bootEloquent());

it('can store commands in the command repository', function (CommandInterface $command) {

    $commandBus = new AsyncCommandBus(new CommandRepository);
    $commandBus->dispatch($command);

    expect(CommandModel::whereId((string) $command->getCommandId())->count())->toBe(1);

})->with([
    [
        new EmptyCommand(),
    ],
]);

it('can pull stored commands from the command repository', function (CommandInterface $command) {

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

it('can consume events stored in the repository', function () {

    $command = new EmptyCommand;
    $handler = new class implements CommandHandlerInterface {
        public static $callCounter = 0;

        public function __invoke($argument): void
        {
            self::$callCounter++;
        }
    };

    $repository = new CommandRepository;
    $commandBus = new AsyncCommandBus($repository);
    $commandBus->dispatch($command);

    $mapper = new CommandMapper([$command::class => $handler::class]);
    $container = (new Instancer())->get(CommandHandlerContainer::class);
    $commandBus = new CommandBus($mapper, $container);

    $commandConsumer = new AsyncCommandConsumer($repository, $commandBus);
    $criteria = new UnprocessedCommandBatchCriteria;
    $commandConsumer->consume($criteria);

    expect($handler::$callCounter)->toBe(1);

});
