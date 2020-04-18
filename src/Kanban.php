<?php

namespace Laurel\Kanban;

use App\Models\Desk;
use Illuminate\Support\ServiceProvider;

class Kanban
{
    private static $instance = null;
    private $currentDesk;

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

    public function setCurrentDesk(Desk $desk) : self
    {
        $this->desk = $desk;
        return $this;
    }

    public function getCurrentDesk() : Desk
    {
        return $this->currentDesk;
    }

    public static function routesApi()
    {
        if (! app()->routesAreCached()) {
            require __DIR__ . '/routes/api.php';
        }
    }
}
