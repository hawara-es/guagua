# Guagua

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
