<?php

namespace Laurel\Kanban\Models;

use Illuminate\Database\Eloquent\Model;

class Collumn extends Model
{
    protected $fillable = ['name', 'order'];

    public function desk()
    {
        return $this->belongsTo(Desk::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
