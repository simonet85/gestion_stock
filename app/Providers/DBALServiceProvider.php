<?php

namespace App\Providers;

use Doctrine\DBAL\Types\Type;
use Illuminate\Support\ServiceProvider;

class DBALServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (!Type::hasType('enum')) {
            Type::addType('enum', \Doctrine\DBAL\Types\StringType::class);
        }
    }
}
