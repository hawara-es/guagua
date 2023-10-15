<?php

use Guagua\Container\EventListenerContainer;
use Guagua\Event\Definition\EventInterface;
use Guagua\Event\Definition\EventListenerInterface;
use Guagua\Event\EventBus;
use Guagua\Event\EventMapper;
use Guagua\Instancer\Instancer;
use Guagua\ValueObject\EventListenerClasses;
use Tests\Fixture\DoNothingOnEmptyEvent;
use Tests\Fixture\EmptyEvent;
use Tests\Fixture\IgnoreEverythingOnEmptyEvent;

it('uses the event mapper to obtain the corresponding event listeners', function (string $event, array $listeners) {

    $mapper = new EventMapper([$event => $listeners]);

    /** @var Guagua\Event\Definition\EventMapperInterface|Mockery\MockInterface $mapperMock */
    $mapperMock = Mockery::mock($mapper);
    $container = (new Instancer())->get(EventListenerContainer::class);
    $eventBus = new EventBus($mapperMock, $container);

    $mapperMock->shouldReceive('get')
        ->once()
        ->andReturn(new EventListenerClasses($listeners));

    $eventBus->publish(new $event);

})->with([
    [
        EmptyEvent::class,
        [
            DoNothingOnEmptyEvent::class,
            IgnoreEverythingOnEmptyEvent::class,
        ],
    ],
]);

it('uses the event listener container to obtain an instance of each of the event listeners', function (string $event, array $listeners) {

    $mapper = new EventMapper([$event => $listeners]);
    $container = (new Instancer())->get(EventListenerContainer::class);

    /** @var Guagua\Container\Definition\EventListenerContainerInterface|Mockery\MockInterface $containerMock */
    $containerMock = Mockery::mock($container);
    $eventBus = new EventBus($mapper, $containerMock);

    $listenerInstances = array_map(fn ($listener) => new $listener, $listeners);

    $containerMock->shouldReceive('get')
        ->times(count($listeners))
        ->andReturn(...$listenerInstances);

    $eventBus->publish(new $event);

})->with([
    [
        EmptyEvent::class,
        [
            DoNothingOnEmptyEvent::class,
            IgnoreEverythingOnEmptyEvent::class,
        ],
    ],
]);

it('fires the event listeners synchronously on publish', function (string $eventClass) {

    $event = new $eventClass();

    class AssertOnEmptyEvent implements EventListenerInterface
    {
        public function __invoke(EventInterface $event): void
        {
            expect(true)->toBe(true);
        }
    }

    $mapper = new EventMapper([$eventClass => [AssertOnEmptyEvent::class]]);
    $container = (new Instancer())->get(EventListenerContainer::class);
    $eventBus = new EventBus($mapper, $container);

    $eventBus->publish($event);

})->with([
    [
        EmptyEvent::class,
    ],
]);