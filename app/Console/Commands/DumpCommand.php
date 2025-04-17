<?php

namespace App\Console\Commands;

use App\Classes\Dump\Dump;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use InvalidArgumentException as GlobalInvalidArgumentException;
use Symfony\Component\Console\Exception\InvalidArgumentException;

/**
 * @codeCoverageIgnore
 */
class DumpCommand extends Command
{
    protected $signature = 'db:dump {--nb_days_to_keep=30} {--zip}';

    protected $description = 'Create a new database dump';

    /**
     * @return void
     *
     * @throws InvalidArgumentException
     * @throws GlobalInvalidArgumentException
     * @throws BindingResolutionException
     */
    public function handle()
    {
        $dump = new Dump($this->option('nb_days_to_keep'), bool_val($this->option('zip')));
        $dump->dump();
    }
}
