<?php

namespace Laurel\Kanban\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Desk extends Model
{
    use SoftDeletes;

    public function collumns()
    {
        return $this->hasMany(Collumn::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
