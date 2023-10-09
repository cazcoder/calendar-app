<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Events\QueryExecuted;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //This fixes the "specified key too long" error after installing and running Laravel's migrations
        Schema::defaultStringLength(191);

        /*DB::listen(function(QueryExecuted $event) {
            Log::info(
                'SQL Query',
                [
                    $event->sql,
                    $event->bindings,
                    $event->time,
                ]
            );
        });*/ 
    }
}
