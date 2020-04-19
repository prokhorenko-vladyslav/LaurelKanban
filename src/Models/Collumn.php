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

    public function setOrder(int $order)
    {
        if ($order < 0) {
            throw new Exception('Order must be more or equal 0');
        }

        $this->order = $order;
        return $this;
    }
}
