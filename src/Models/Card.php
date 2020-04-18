<?php

namespace Laurel\Kanban\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    public function desk()
    {
        return $this->newHasOneThrough(Desk::class, Collumn::class);
    }

    public function collumn()
    {
        return $this->belongTo(Card::class);
    }
}
