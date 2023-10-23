<?php

namespace Tests;

use Guagua\Command\Implementation\Eloquent\CommandMigration;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Builder;

class EloquentTestCase extends TestCase
{
    public function bootEloquent()
    {
        $capsule = new Capsule;

        $connection = [
            'driver' => 'sqlite',
            'database' => ':memory:',
        ];

        $capsule->addConnection($connection);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        $this->runMigrations($capsule->schema());
    }

    private function runMigrations(Builder $builder)
    {
        (new CommandMigration($builder))->up();
    }
}