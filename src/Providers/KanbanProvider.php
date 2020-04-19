<?php

namespace Laurel\Kanban\Providers;

use Illuminate\Support\ServiceProvider;
use Laurel\Kanban\Http\Controllers\DeskController;
use Laurel\Kanban\Http\Controllers\CollumnController;
use Laurel\Kanban\Http\Controllers\CardController;
use Illuminate\Support\Facades\Auth;

class KanbanProvider extends ServiceProvider
{
    protected $namespace = 'Laurel\Kanban\Http\Controllers';

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Auth::loginUsingId(1);
        $this->loadMigrationsFrom(__DIR__ . "/../database/migrations");
        $this->publishes([
            __DIR__ . "/../config/laurel_kanban.php" => config_path('laurel_kanban.php')
        ]);
        $this->mergeConfigFrom(__DIR__ . "/../config/laurel_kanban.php", 'laurel_kanban');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make(DeskController::class);
        $this->app->make(CollumnController::class);
        $this->app->make(CardController::class);
    }
}
