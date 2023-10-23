<?php

declare(strict_types=1);

namespace Guagua\Command\Implementation\Eloquent;

use Criba\Criteria;
use Criba\Infrastructure\Eloquent\EloquentCriteriaBuilder;
use Guagua\Command\Definition\CommandInterface;
use Guagua\ValueObject\CommandClass;
use Guagua\ValueObject\Uuid;
use Illuminate\Support\Facades\Date;
use Illuminate\Database\Capsule\Manager as DB;

class CommandRepository
{
    private EloquentCriteriaBuilder $builder;

    public function __construct() {
        $this->builder = new EloquentCriteriaBuilder(CommandModel::class);
    }

    public function save(CommandInterface $command): void
    {
        $id = (string) $command->getCommandId() ?? Uuid::random();

        CommandModel::updateOrCreate(['id' => $id], [
            'created_at' => Date::now(),
            'command_class' => $command::class,
            'command_body' => $command,
        ]);
    }

    /** @return CommandInterface[] */
    public function pull(Criteria $criteria): array
    {
        return DB::transaction(function() use($criteria) {
            $pulled = $this->builder->query($criteria)->lockForUpdate()->get();

            CommandModel::whereIn('id', $pulled->pluck('id'))
                ->update(['processed_at' => \Carbon\Carbon::now()]);

            return $pulled->map(fn ($record) => $this->map($record))->all();
        });
    }

    private function map(CommandModel $record): CommandInterface
    {
        $commandClass = new CommandClass($record->command_class);
        $reflection = new \ReflectionClass($commandClass->get());

        /** @var CommandInterface $result */
        $result = $reflection->newInstanceArgs((array) $record->command_body);
        return $result;
    }
}
