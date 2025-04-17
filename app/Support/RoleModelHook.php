<?php

namespace App\Support;

use Barryvdh\LaravelIdeHelper\Console\ModelsCommand;
use Barryvdh\LaravelIdeHelper\Contracts\ModelHookInterface;
use Illuminate\Database\Eloquent\Model;

class RoleModelHook implements ModelHookInterface
{
    /**
     * Run the hook to modify the model's DocBlock.
     *
     * @param  ModelsCommand  $command
     * @param  Model  $model
     *
     * @return void
     */
    public function run(ModelsCommand $command, Model $model): void
    {
        \Log::info('RoleModelHook is running...');
        \Log::info('Model class: ' . $model::class);
        if ($model instanceof \App\Models\Commun\Role) {
            \Log::info('Role model identified.');
            $method = 'whereAssignedTo';
            $command->setMethod(
                $method,
                '\Illuminate\Database\Eloquent\Builder',
                'whereAssignedTo($model, ?array<int|string> $keys = null)'
            );
            $property = 'assignedTo';
            $command->setProperty(
                $property,
                'array<int|string>|null',
                null
            );
        } else {
            \Log::info('The model is not the Role model.');
        }
    }
}
