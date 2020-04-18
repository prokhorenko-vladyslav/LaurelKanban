<?php

namespace Laurel\Kanban\Models;

use Illuminate\Database\Eloquent\Model;

class Desk extends Model
{
    public function collumns()
    {
        return $this->hasMany(Collumn::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
