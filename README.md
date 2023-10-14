# Guagua

Guagua is a PHP implementation of a [command bus](#command-bus), a [query bus](#query-bus) and an [event bus](#event-bus).

> **Note**: This software is still in an development stage. As it is still incomplete, no production version has been yet released. If you are interested in it, please follow the [milestone for the v1.0.0](https://github.com/hawara-es/guagua/milestone/1).

## Command bus

### Commands

Create a command by implementing Guagua's command interface.

```php
use Guagua\Command\Definition\CommandInterface;

class DeleteUserCommand implements CommandInterface
{
    public function __construct(
        public readonly string $id
    ) {
        //
    }
}
```

Remember to define your commands as immutable data carriers without behaviour.

> **See**: [CommandInterface.php](src/Command/Definition/CommandInterface.php).

### Command handlers

Create a command handler by implementing Guagua's command handler interface and implementing the corresponding behaviour in an **invoke** method, which must receive the command as its **argument**.

```php
use Guagua\Command\Definition\CommandHandlerInterface;

class DeleteUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepository $repository
    ) {
        //
    }

    /** @param  DeleteUserCommand  $argument */
    public function __invoke($argument): void
    {
        $this->repository->delete($argument->id);
    }
}
```

Generally speaking, this will be the unique public method of your command handlers, along with the constructor which you are encouraged to use in order to inject its dependencies.

> **See**: [CommandHandlerInterface.php](src/Command/Definition/CommandHandlerInterface.php)

### Command mapper

Maintain a list of all the relationships between your commands and their handlers by extending Guagua's command mapper.

```php
use Guagua\Command\CommandMapper;

class MyCommandMapper extends CommandMapper
{
    public function __construct()
    {
        $maps = [
            DeleteUserCommand::class => DeleteUserCommandHandler::class,
        ];

        parent::__construct($maps);
    }
}
```

> **See**: [CommandMapper.php](src/Command/CommandMapper.php)

## Query bus

### Queries

Create a query by implementing Guagua's query interface.

```php
use Guagua\Query\Definition\QueryInterface;

class GetUserQuery implements QueryInterface
{
    public function __construct(
        public readonly string $id
    ) {
        //
    }
}
```

As with commands, remember to define your queries as data carriers without behaviour.

> **See**: [QueryInterface.php](src/Query/Definition/QueryInterface.php)

### Query responses

Create a query response by implementing Guagua's query response interface.

```php
use Guagua\Query\Definition\QueryResponseInterface;

class GetUserQueryResponse implements QueryResponseInterface
{
    public function __construct(
        public readonly ?User $user = null
    ) {
        //
    }
}
```

> **See**: [QueryResponseInterface.php](src/Query/Definition/QueryResponseInterface.php)

### Query handlers

Create a query handler by implementing Guagua's query handler interface and implementing the corresponding behaviour in an **invoke** method, which must receive the query as its **argument**.

```php
use Guagua\Query\Definition\QueryHandlerInterface;

class GetUserQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private UserRepository $repository
    ) {
        //
    }

    /** @param  GetUserQuery  $argument */
    public function __invoke($argument): QueryResponseInterface;
    {
        $user = $this->repository->find($argument->id);

        return new QueryResponse($user);
    }
}
```

Pay attention to the return value of the method, as the main difference with the command bus is that in this case a response is mandatory and it has to implement query response interface.

> **See**: [QueryHandlerInterface.php](src/Query/Definition/QueryHandlerInterface.php)

### Query mapper

Maintain a list of all the relationships between your queries and their handlers by extending Guagua's query mapper.

```php
use Guagua\Query\QueryMapper;

class MyQueryMapper extends QueryMapper
{
    public function __construct()
    {
        $maps = [
            GetUserQuery::class => GetUserQueryHandler::class,
        ];

        parent::__construct($maps);
    }
}
```

> **See**: [QueryMapper.php](src/Query/QueryMapper.php)

## Event Bus

### Events

Create an event by implementing Guagua's event interface.

```php
use Guagua\Event\Definition\EventInterface;

class UserCreatedEvent implements EventInterface
{
    public function __construct(
        public readonly string $userId
    ) {
        //
    }
}
```

As with commands and queries, remember to define your events as data carriers without behaviour.

> **See**: [EventInterface.php](src/Event/Definition/EventInterface.php)

### Event Listeners

Create an event listener by implementing Guagua's event listener interface and implementing the corresponding behaviour in an **invoke** method, which must receive the event as its **argument**.

```php
use Guagua\Event\Definition\EventListenerInterface;

class WriteLogOnUserCreatedEvent implements EventListenerInterface
{
    public function __construct(
        private LogWriter $logger
    ) {
        //
    }

    /** @param  UserCreatedEvent  $event */
    public function __invoke(EventInterface $event): void
    {
        $this->logger->write('A new user has just been created: '.$event->userId);
    }
}
```

> **See**: [EventListenerInterface.php](src/Event/Definition/EventListenerInterface.php)

### Event mapper

Maintain a list of all the relationships between your events and their listeners by extending Guagua's event mapper.

```php
use Guagua\Event\EventMapper;

class MyEventMapper extends EventMapper
{
    public function __construct()
    {
        $maps = [
            UserCreatedEvent::class => [
                WriteLogOnUserCreatedEvent::class,
                OtherActionOnUserCreatedEvent::class,
            ],
        ];

        parent::__construct($maps);
    }
}
```

> **See**: [EventMapper.php](src/Event/EventMapper.php)

## Instancer

### Implementation solver

Make the instancer use your mappers every time a service needs a command mapper, a query mapper or an event mapper by initializing it with your own implementation solver.

```php
use Guagua\Instancer\ImplementationSolver;
use Guagua\Command\Definition\CommandMapperInterface;
use Guagua\Query\Definition\QueryMapperInterface;
use Guagua\Event\Definition\EventMapperInterface;

$solver = new ImplementationSolver([
    CommandMapperInterface::class => MyCommandMapper::class,
    QueryMapperInterface::class => MyQueryMapper::class,
    EventMapperInterface::class => MyEventMapper::class,
]);

$instancer = new Guagua\Instancer\Instancer($solver);
```

> **See**: [ImplementationSolver.php](src/Instancer/ImplementationSolver.php)

### Instancer

Now you can use the instancer to get a command bus that knows about your commands and their handlers.

```php
use Guagua\Command\Definition\CommandBusInterface;

$command = new DeleteUserCommand('1915d46b-e8a9-4da3-99cd-4a313c2b7b6f');
$commandBus = $instancer->get(CommandBusInterface::class);
$commandBus->dispatch($command);
```

Similarly, you can also use it to get a query bus that knows about your queries and their handlers.

```php
use Guagua\Query\Definition\QueryBusInterface;

$query = new GetUserQuery('1915d46b-e8a9-4da3-99cd-4a313c2b7b6f');
$queryBus = $instancer->get(QueryBusInterface::class);
$user = $queryBus->ask($query);
```

Finally, you can use it to get an event bus that knows about your events and their listeners.

```php
use Guagua\Event\Definition\EventBusInterface;

$event = new NewUserCreatedEvent('1915d46b-e8a9-4da3-99cd-4a313c2b7b6f');
$eventBus = $instancer->get(EventBusInterface::class);
$eventBus->publish($event);
```

> **See**: [Instancer.php](src/Instancer/Instancer.php)

### Via GitHub (recommended for development)

If instead you want to modify this package itself (for instance, to send a pull request), you are encouraged to clone this repository using Git.

```bash
git clone https://github.com/hawara-es/guagua.git

composer install

# optionally, you can install the package in production mode
# but you won't be able to run the test suite
composer install --no-dev
```


## Open a debug session

The [PsySH](https://psysh.org) debugger is installed as a Composer dependency, what means that you can quickly open an interactive PHP session to test a bus by running:

```bash
vendor/bin/psysh
```

The session will autoload the project namespaces, so you can very rapidly start having fun:

```php
$instancer = new Guagua\Instancer\Instancer;
$instancer->get(Guagua\Command\CommandBus::class);
```

## Run the tests

The [Pest](https://pestphp.com) test engine helps tests being beautiful, readable, quick and are integrated into a GitHub workflow, so every pull request will run them.

```bash
vendor/bin/pest
```

## Fix the code style

The [Pint](https://laravel.com/docs/10.x/pint) code style fixer has been set up to facilitate following Laravel's suggested coding styles.

```bash
vendor/bin/pint
```
