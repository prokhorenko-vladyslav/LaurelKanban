<?php

namespace Laurel\Kanban;

use Laurel\Kanban\Models\Desk;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

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

    public static function getUserDesks()
    {
        return Desk::where('user_id', Auth::id());
    }
}
