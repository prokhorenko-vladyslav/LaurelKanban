<?php

namespace Laurel\Kanban;

use App\Models\Desk;

class Kanban
{
    private static $instance = null;
    private $currentDesk;

    private function __construct()
    {
    }

    public static function getInstance() : self
    {
        if (!$this->instance) {
            $this->instance = new self;
        }

        return $this->instance;
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
}
