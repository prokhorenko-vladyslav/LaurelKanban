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

    public function user()
    {
        return $this->belongsTo(config('laurel_kanban.user_class'), 'user_id');
    }
}
