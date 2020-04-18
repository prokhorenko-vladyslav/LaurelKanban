<?php

namespace Laurel\Kanban\Providers;

use Illuminate\Support\ServiceProvider;
use Laurel\Kanban\Http\Controllers\DeskController;
use Laurel\Kanban\Http\Controllers\CollumnController;
use Laurel\Kanban\Http\Controllers\CardController;

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
        $this->loadRoutesFrom(__DIR__ . "/../routes/api.php");
        $this->loadMigrationsFrom(__DIR__ . "/../database/migrations");
        $this->publishes([
            __DIR__ . "/../config/laurel.kanban.php" => config_path('laurel.kanban.php')
        ]);
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
