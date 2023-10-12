# Guagua

Guagua is a PHP implementation of a command, query and event buses.

## Command bus

### Commands

To use Guagua's **command bus** it in your application, first define your commands by inheriting [CommandInterface](src/Command/Definition/CommandInterface.php):

```php
class DeleteUserCommand extends \Guagua\Command\Definition\CommandInterface
{
    public readonly string $id;
}
```

Remember to define your commands as data carriers without behaviour.

### Command handlers

Then create a handler for each command by extending [CommandHandlerInterface](src/Command/Definition/CommandHandlerInterface.php) and implementing the corresponding behaviour in its `__invoke` method.

```php
class DeleteUserCommandHandler extends \Guagua\Command\Definition\CommandHandlerInterface
{
    /** @param  DeleteUserCommand  $argument */
    public function __invoke($argument): void
    {
        User::delete($argument->id);
    }
}
```

Generally speaking, this will be the unique public method of your command handlers.

### Command mapper

Extending the [CommandMapper](src/Command/CommandMapper.php) is an easy way to maintain a list of all the relations between your command and their handlers:

```php
class MyCommandMapper extends \Guagua\Command\CommandMapper
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

### Instancer

Finally, you can easily make the [Instancer](src/Instancer/Instancer.php) use your mapper every time it needs a [CommandMapperInterface](src/Command/Definition/CommandMapperInterface.php):

```php
$solver = new Guagua\Instancer\ImplementationSolver([
    Guagua\Command\Definition\CommandMapperInstancer => MyCommandMapper::class,
]);

$instancer = new Guagua\Instancer\Instancer($solver);

// Now you can use the instancer to get a command bus that knows about your commands
$commandBus = $instancer->get(Guagua\Command\Definition\CommandBusInterface::class);
$commandBus->dispatch(new DeleteUserCommand(1));
```

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
