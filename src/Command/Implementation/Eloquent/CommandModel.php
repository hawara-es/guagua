<?php

declare(strict_types=1);

namespace Guagua\Command\Implementation\Eloquent;

use Guagua\ValueObject\CommandClass;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class CommandModel extends Model
{
    protected $table = 'commands';

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'created_at',
        'processed_at',
        'command_class',
        'command_body',
    ];

    protected $casts = [
        'command_body' => 'object',
    ];

    public static function booted()
    {
        static::creating(function ($command) {
            $command->created_at = $command->freshTimestamp();
        });
    }

    protected function commandClass(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => (new CommandClass($value))->get(),
            set: fn (string $value) => (new CommandClass($value))->get(),
        );
    }

    protected function commandBody(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => json_decode($value, flags: JSON_THROW_ON_ERROR),
            set: fn ($value) => json_encode($value, flags: JSON_THROW_ON_ERROR),
        );
    }
}
