<?php

declare(strict_types=1);

namespace Guagua\Command\Implementation\Eloquent;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

class CommandMigration
{
    public function __construct(
        private Builder $builder
    ) {
        //
    }

    public function up(): void
    {
        $this->builder->create('commands', function (Blueprint $table) {
            $table->uuid('id');
            $table->timestamp('created_at');
            $table->timestamp('processed_at')->nullable();
            $table->string('command_class');
            $table->json('command_body');
            $table->index(['id']);
            $table->index(['created_at', 'processed_at']);
            $table->index(['created_at', 'processed_at', 'command_class']);
        });
    }

    public function down(): void
    {
        $this->builder->drop('commands');
    }
}
