<?php

namespace Laurel\Kanban;

use Laurel\Kanban\Models\Desk;
use Illuminate\Support\ServiceProvider;

class Kanban
{
    private static $instance = null;

    private function __construct()
    {
    }

    public static function instance() : self
    {
        if (!self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public static function routesApi()
    {
        if (! app()->routesAreCached()) {
            require __DIR__ . '/routes/api.php';
        }
    }
}
