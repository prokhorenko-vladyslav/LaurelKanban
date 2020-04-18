<?php

namespace Laurel\Kanban\Models;

use Illuminate\Database\Eloquent\Model;

class Collumn extends Model
{
    public function desk()
    {
        return $this->belongTo(Desk::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
